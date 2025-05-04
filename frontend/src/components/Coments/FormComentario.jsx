import React, { useEffect, useState } from "react";
import { inserirComentario } from "../../services/postsService";
import Status from "../../components/Status/Status"
function FormComentario({ id_autor, slug }) {
    const [status, setStatus] = useState({});
    const handleSubmit = async (event) => {
        event.preventDefault();
        const conteudo = event.target.comentar.value;
        // console.log(conteudo);

        try {
            // Aguarda a resposta da função inserirComentario
            const resposta = await inserirComentario(slug, id_autor, conteudo);

            // Atualiza o estado com a resposta
            if (resposta) {
                setStatus(resposta);
            }
        } catch (error) {
            console.error("Erro ao inserir comentário:", error);
            setStatus({
                status: "error",
                message: "Erro ao inserir comentário.",
                codigo: 500,
            });
        }
        setTimeout(() => {
            window.location.reload();
        }, 3000);

    };
    return (<>
        {status && status.status && (<Status status={status.status} mensagem={status.message} codigo={status.codigo}/>)}
        <form className="flex gap-3" onSubmit={handleSubmit}>
            <input type="text" name="comentar" id="comentar" placeholder="Adicionar um comentário a publicação: " 
            className="w-full border-2 h-[70px] p-4 rounded-1xl "
            />
            <button className="">Enviar</button>
        </form>
    </>)
}   

export default FormComentario