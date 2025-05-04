import React, { useEffect, useState } from "react";
import { getComents } from "../../services/postsService";
import { decodeToken } from "../../services/tokenDecode";
import FormComentario from "./FormComentario";
import profileDefault from "../../assets/profile-default.png"
function Comentarios(slug) {
    const [coments, setComents] = useState([]);
    const [dados, setDados] = useState({});
    useEffect(() => {
        const fetchComents = async () => {
            try {
                // console.log(slug.slug);
                const response = await getComents(slug.slug);
                // console.log("Resposta completa da API:", response);
                if (response && response.data) {
                    setComents(response.data);
                    // console.log(response.data);
                }
            } catch (error) {
                console.error("Erro ao buscar comentários:", error);
            }
        };

        fetchComents(); // Chama a função assíncrona
    }, [slug]);

    useEffect(() => {
        const token = localStorage.getItem("token");
        const tokenDecodificado = decodeToken(token);
        setDados(tokenDecodificado.data);

    }, [])
return (
    <>
        <p className="italic mt-20 text-2xl">Comentários:</p>
        <div className="bg-gray-800  rounded-xl shadow-md p-4 space-y-4">
            {coments.length > 0 ? (
                coments.map((coment, index) => (
                    <div key={index} className="p-4 border border-gray-500 rounded-lg bg-gray-500">
                        <div className="flex items-center mb-2">
                            <img
                                src={coment.img_autor ? coment.img_autor : profileDefault}
                                alt={`Foto de ${coment.name_autor}`}
                                className="w-10 h-10 rounded-full mr-3 border border-gray-300"
                            />
                            <span className="text-white font-medium">{coment.name_autor}</span>
                        </div>
                        <p className="text-white text-base">{coment.conteudo}</p>
                    </div>
                ))
            ) : (
                <p className="text-white italic">Nenhum comentário encontrado.</p>
            )}
            {dados && dados.id && <FormComentario id_autor={dados.id} slug={slug.slug} />}
        </div>
    </>
);

    

}

export default Comentarios;