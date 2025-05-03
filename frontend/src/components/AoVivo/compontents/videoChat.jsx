import React, { useState } from 'react';
import ChatBoot from './ChatBoot';
import styles from '../AoVivo.module.css'

function VideoChat() {
    const [mensagem, setMensagem] = useState('');
    const [mensagensUsuario, setMensagensUsuario] = useState([]);

    const adicionarEmoji = (emoji) => {
        setMensagem((prev) => prev + emoji);
    };

    const enviarMensagem = (e) => {
        e.preventDefault();
        if (mensagem.trim() !== '') {
            setMensagensUsuario((prev) => [
                ...prev,
                { mensagem, nome: "Você" }
            ]);
            setMensagem('');
        }
    };
    return (
        <>
            <div className='w-[60%] h-[315px] border-2 rounded-2xl border-[var(--main-border-color)] flex flex-col justify-end gap-4 bg-gray-800 min-w-[300px] '>
                <ChatBoot mensagensUsuario={mensagensUsuario} />
                <div className='flex w-full justify-center'>
                    <div className='flex gap-5 justify-around w-[90%] overflow-hidden whitespace-nowrap text-ellipsis text-xl'>
                        {["🔥", "🐍", "💥", "😁", "👍", "❤️", "🤦‍♂️", "🤞", "🥱", "😡"].map((emoji, index) => (
                            <button
                                key={index}
                                type="button"
                                onClick={() => adicionarEmoji(emoji)}
                                className='text-xl'
                            >
                                {emoji}
                            </button>
                        ))}
                    </div>

                </div>
                <form className='w-full flex justify-between' onSubmit={enviarMensagem}>
                    <input
                        type="text"
                        className='w-[80%] h-[60px] border-2 mb-4 rounded-4xl border-[var(--main-border-color)] p-3 ml-5'
                        placeholder='Comente ao Vivo com outros usuários ...'
                        value={mensagem}
                        onChange={(e) => setMensagem(e.target.value)}
                    />
                    <button className='h-[60px] border-2 mb-4 rounded-4xl border-[var(--main-border-color)] p-3 mr-5'>Send</button>
                </form>
            </div>
        </>
    );
}

export default VideoChat;
