import React, { useState } from 'react';

function FormAlterarSenha({ onSubmit }) { // Recebe a prop onSubmit
    const [novaSenha, setNovaSenha] = useState('');
    const [senha, setSenha] = useState('');

    const handleSubmit = (e) => {
        e.preventDefault(); // Impede o comportamento padrão do formulário
        if (onSubmit) {
            onSubmit(novaSenha, senha); // Chama o callback com os valores
        }
    };

    return (
        <div>
            <form onSubmit={handleSubmit}>
                <label htmlFor="novaSenha">Nova Senha:</label>
                <input
                    type="password"
                    id="novaSenha"
                    name="novaSenha"
                    value={novaSenha}
                    onChange={(e) => setNovaSenha(e.target.value)} // Atualiza o estado
                    className="my-[5px] w-full h-10 rounded-md bg-gray-900 border-2 border-[var(--main-border-color)] p-2"
                    required
                    placeholder="Digite a nova senha: "
                />
                <label htmlFor="senhaAtual">Senha Atual:</label>
                <input
                    type="password"
                    id="senhaAtual"
                    name="senhaAtual"
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

export default FormAlterarSenha;