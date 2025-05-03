import React, { useState } from 'react';

function FormAlterarEmail({ onSubmit }) { // Recebe a prop onSubmit
    const [novoEmail, setNovoEmail] = useState('');
    const [senha, setSenha] = useState('');

    const handleSubmit = (e) => {
        e.preventDefault(); // Impede o comportamento padrão do formulário
        if (onSubmit) {
            onSubmit(novoEmail, senha); // Chama o callback com os valores
        }
    };

    return (
        <div>
            <form onSubmit={handleSubmit}>
                <label htmlFor="email1">Alterar Email:</label>
                <input
                    type="email"
                    id="email1"
                    name="email1"
                    value={novoEmail}
                    onChange={(e) => setNovoEmail(e.target.value)} // Atualiza o estado
                    className="my-[5px] w-full h-10 rounded-md bg-gray-900 border-2 border-[var(--main-border-color)] p-2"
                    required
                    placeholder="Digite o novo email: "
                />
                <input
                    type="password"
                    id="passwordEmail"
                    name="passwordEmail"
                    value={senha}
                    onChange={(e) => setSenha(e.target.value)} // Atualiza o estado
                    className="my-[5px] w-full h-10 rounded-md bg-gray-900 border-2 border-[var(--main-border-color)] p-2"
                    required
                    placeholder="Digite a senha atual: "
                />
                <div className="relative w-full h-10">
                    <button className="btnmin w-23 h-9 absolute right-0 bottom-0">Confirmar</button>
                </div>
            </form>
        </div>
    );
}

export default FormAlterarEmail;