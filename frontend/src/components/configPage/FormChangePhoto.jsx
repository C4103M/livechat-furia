import React, { useState } from 'react';

function FormAlterarFoto({ userImg, onSubmit }) { // Recebe a prop onSubmit
    const [novaFoto, setNovaFoto] = useState(null);

    const handleFileChange = (e) => {
        setNovaFoto(e.target.files[0]); // Captura o arquivo selecionado
    };

    const handleSubmit = (e) => {
        e.preventDefault(); // Impede o comportamento padrão do formulário
        console.log('Arquivo para envio:', novaFoto);
        if (onSubmit && novaFoto) {
            onSubmit(novaFoto); // Chama o callback com o arquivo da nova foto
        }
    };

    return (
        <form onSubmit={handleSubmit}>
            <p>Alterar Foto:</p>
            <div className="flex width-full justify-between">
                <label
                    htmlFor="foto"
                    className="cursor-pointer my-[10px] w-[120px] h-[120px] rounded-full bg-gray-900 border-2 border-[var(--main-border-color)] overflow-hidden"
                >
                    <img src={userImg} alt="Foto de perfil" className="w-full h-full object-cover" />
                </label>
                <input
                    type="file"
                    id="foto"
                    name="foto"
                    className="hidden"
                    accept="image/*" // Aceita apenas arquivos de imagem
                    onChange={handleFileChange} // Atualiza o estado com o arquivo selecionado
                    required
                />
                <div className="relative h-full">
                    <button type="submit" className="btnmin w-23 h-9">
                        Confirmar
                    </button>
                </div>
            </div>
        </form>
    );
}

export default FormAlterarFoto;