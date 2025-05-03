import React, { useState } from 'react';

function FormAlterarNome({ onSubmit }) { // Recebe a prop onSubmit
    const [novoNome, setNovoNome] = useState('');
    const [senha, setSenha] = useState('');

    const handleSubmit = (e) => {
        e.preventDefault(); // Impede o comportamento padrão do formulário
        if (onSubmit) {
            onSubmit(novoNome, senha); // Chama o callback com os valores
        }
    };

    return (
        <div>
            <form onSubmit={handleSubmit}>
                <label htmlFor="username1">Alterar Nome:</label>
                <input
                    type="text"
                    id="username1"
                    name="username1"
                    value={novoNome}
                    onChange={(e) => setNovoNome(e.target.value)}
                    className="my-[5px] w-full h-10 rounded-md bg-gray-900 border-2 border-[var(--main-border-color)] p-2"
                    required
                    placeholder="Digite o novo nome: "
                />
                <input
                    type="password"
                    id="passwordName"
                    name="passwordName"
                    value={senha}
                    onChange={(e) => setSenha(e.target.value)}
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

export default FormAlterarNome;