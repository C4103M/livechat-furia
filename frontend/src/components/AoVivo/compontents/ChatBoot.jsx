import React, { useState, useEffect, useRef } from 'react';
import profileDefault from '../../../assets/profile-default.png'
import styles from '../AoVivo.module.css'
function ChatBoot({ mensagensUsuario }) {
    const [mensagemBoot, setMensagemBoot] = useState([]);
    const prevMensagens = useRef([]);
    const mensagensChat = [
        "🔥 VAMO FURIA!",
        "🐍 O arT tá jogando muito!",
        "💥 Que bala foi essa do FalleN?",
        "👀 Alguém viu aquele clutch?",
        "😱 2x5 e ganharam!",
        "🧠 Estratégia insana agora",
        "🎯 Kscerato monstro demais!",
        "🔥 Essa call foi perfeita!",
        "🐾 É agora FURIAAAA!",
        "🛡️ Que defesa foi essa?!",
        "💣 Plantaram no último segundo!",
        "🦾 Dominando o mapa como sempre!",
        "📢 A torcida tá maluca!",
        "🧊 Calmaria antes da próxima bala...",
        "⚔️ Que duelo tenso!",
        "🚀 Que início de round absurdo!",
        "🧨 Explodiram tudo no bomb!",
        "🧤 Que reflexo do yuurih!",
        "🔥 TÁ PEGANDO FOGO ESSE ROUND!",
        "👑 FalleN comandando com maestria!",
        "💪 Ninguém segura a FURIA hoje!",
        "🎮 CS de altíssimo nível!",
        "🧩 Jogada ensaiada perfeita!",
        "📈 Só melhora a cada round!",
        "🦁 RUGINDO FORTE COMO SEMPRE!",
        "🧱 Que paredão na defesa!",
        "👣 Flanco insano agora!",
        "⚡ Entraram voando no bomb!",
        "📺 Tô grudado na tela!",
        "💼 Técnico mandou bem demais!",
        "🎯 HS limpo, limpo!",
        "📊 Stat do arT tá absurdo!",
        "🔊 A torcida virtual não para!",
        "🏆 Jogando como campeões!",
        "🧠 Leram a jogada toda!",
        "🕹️ Isso aqui é highlight de Major!"

    ]
    const nomesBoot = [
        "Sérgio Bastos",
        "Lucas",
        "Ana",
        "MATARO",
        "TUL17Z",
        "SZKSS",
        'C410',
        'Blackn999',
        'O Espanca b**',
    ]
    useEffect(() => {
        let intervalo = setInterval(() => guardarMensagem(gerarMensagem()), 5000);
        return () => clearInterval(intervalo);

    }, []);
    useEffect(() => {
        // Só executa se for adicionada uma nova mensagem
        if (mensagensUsuario.length > prevMensagens.current.length) {
            const novoItem = mensagensUsuario[mensagensUsuario.length - 1];
            guardarMensagem(novoItem); // Aqui eu passo só o novo item
        }

        // Atualiza a referência para o próximo useEffect
        prevMensagens.current = mensagensUsuario;
    }, [mensagensUsuario]);
    const gerarMensagem = () => {
        let numNomes = nomesBoot.length;
        let numMensagens = mensagensChat.length;
        let aleatoryName = Math.floor(Math.random() * numNomes);
        let aleatoryMessage = Math.floor(Math.random() * numMensagens);
        let mensagem = {
            "mensagem": mensagensChat[aleatoryMessage],
            "nome": nomesBoot[aleatoryName],
        };
        return mensagem;
    }
    const guardarMensagem = (msg) => {
        setMensagemBoot(prev => [...prev, msg]);
    };

    return (
        <>
            <div className="w-full flex justify-center ">
                <div className={`border-2 w-[90%] h-[130px] flex flex-col justify-end border-[var(--main-border-color)] rounded-2xl overflow-y-auto bg-gray-600`}>
                    {/* Exibindo mensagens de boots */}
                    {mensagemBoot.map((msg, index) => (
                        <div key={index} className={`p-2 w-full flex gap-2 relative ${msg.nome == 'Você' ? 'justify-start' : 'justify-end'}`}>
                            <p className='text-[12px] absolute top-[-5px] right-10 text-gray-400'><i>{msg.nome}</i></p>
                            <p className=''>{msg.mensagem}</p>
                            <div className="w-[25px] h-[25px] rounded-full border-2 overflow-hidden">
                                <img src={profileDefault} alt="profile" className="w-full h-full object-cover" />
                            </div>
                        </div>
                    ))}
                </div>
            </div>
        </>
    );
};

export default ChatBoot;