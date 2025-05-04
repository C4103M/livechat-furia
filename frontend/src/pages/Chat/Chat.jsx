import React, { useEffect, useRef, useState } from "react";
import Header from "../../components/Header/Header";
import { useParams } from "react-router-dom";
import * as messageServices from '../../services/messageService';
import { decodeToken } from '../../services/tokenDecode';

function Chat() {
    const { user_id } = useParams();
    const mensagensEndRef = useRef(null);
    const [mensagens, setMensagens] = useState([]);
    const [dados, setDados] = useState({});
    const [my_id, setMyId] = useState(1);
    const [mensagemInput, setMensagemInput] = useState('');
    const [visible, isVisible] = useState(false);
    useEffect(() => {
        const token = localStorage.getItem('token');
        if (token) {
            const user = decodeToken(token);
            setDados(user);
            setMyId(user.data.id);
        } else {
            window.location.href = '/';
        }
    }, [])
    useEffect(() => {
        scrollToBottom();
    }, [mensagens]);
    const scrollToBottom = () => {
        mensagensEndRef.current?.scrollIntoView({ behavior: 'smooth' });
    };

    const handleSubmit = async (e) => {
        e.preventDefault();

        if (mensagemInput.trim() === '') return;

        try {
            await messageServices.enviarMensagem(my_id, user_id, mensagemInput);
            setMensagemInput(''); // limpa input após envio
        } catch (error) {
            console.error("Erro ao enviar mensagem:", error);
        }
    };

    useEffect(() => {
        if (dados && dados.data) {
            const intervalo = setInterval(async () => {
                try {
                    const resposta = await messageServices.buscarConversa(my_id, user_id);
                    if (resposta.status != 'void') {
                        isVisible(true);
                        setMensagens(resposta.data);
                    } else {
                        setMensagens([{
                            content: "Inicie a conversa!",
                            remetente_id: null,
                            systemMessage: true
                        }]);
                    }
                } catch (error) {
                    console.error("Erro ao buscar mensagens:", error);
                }
            }, 1000);

            return () => clearInterval(intervalo);
        }
    }, [user_id, dados.data]);

    return (
        <>
            <Header />
            <div className="flex justify-center w-[100%] ">
                <div className="w-[30%] min-h-[700px] border-2 m-4 p-2 flex flex-col justify-between bg-gray-900 rounded-2xl">
                    {/* Lista de mensagens */}

                    <div className={`flex flex-col justify-end gap-2 overflow-y-auto h-full mb-4 ${!visible ? 'hidden' : ''}`}>
                        {Array.isArray(mensagens) && mensagens.length > 0 ? (
                            mensagens.map((msg, index) => (
                                <div
                                    key={index}
                                    className={`p-2 rounded-xl w-fit max-w-[70%] ${msg.remetente_id !== my_id ? 'bg-gray-500 self-start' : 'bg-blue-400 self-end'
                                        }`}
                                >
                                    {msg.content}
                                </div>
                            ))
                        ) : (
                            <p className="text-center text-gray-400 italic">Nenhuma mensagem encontrada.</p>
                        )}
                    </div>
                    <div ref={mensagensEndRef} />
                    {/* Input de envio */}
                    <form onSubmit={handleSubmit} className="flex justify-center w-full gap-2">
                        <input
                            className="w-[90%] border-2 p-3 rounded-2xl"
                            type="text"
                            name="send_msg"
                            id="send_msg"
                            placeholder="Digite sua mensagem"
                            value={mensagemInput}
                            onChange={(e) => setMensagemInput(e.target.value)}
                        />
                        <button type="submit" className="px-4 rounded-xl bg-blue-500 text-white">Enviar</button>
                    </form>
                </div>
            </div>
        </>
    );
}

export default Chat;
