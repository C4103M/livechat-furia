import React, { useEffect, useState } from 'react';
import { useParams } from 'react-router-dom';
import * as postService from '../../services/postsService';
import Header from '../../components/Header/Header';
function Slug() {
    const { slug } = useParams();
    const [noticia, setNoticia] = useState({});
    const [visibleContent, setVisibleContent] = useState(false);

    useEffect(() => {
        const fetchNoticia = async () => {
            try {
                const responseNoticia = await postService.buscarNoticia(slug);
                setNoticia(responseNoticia);
            } catch (error) {
                console.error("Erro ao buscar notícia:", error);
            }
        };
        fetchNoticia();
    }, [slug])
    useEffect(() => {
        if (noticia && noticia.data) {
            console.log(noticia.data);
            setVisibleContent(true);
        }
    }, [noticia])

    return (
        <>
            <Header />
            {noticia?.data ? (
                <div className='w-full h-full flex justify-center'>
                    <div className='w-[40%] p-10 h-fit border-[var(--main-border-color)] border-2 rounded-2xl m-10'>
                        <h1 className='text-3xl font-extrabold mb-4' >{noticia.data.titulo}</h1>
                        <div className='flex justify-between'>
                            <p className='text-gray-500'>Data da Publicação: {noticia.data.data_publicacao}</p>
                            <p className='text-gray-500 '>Autor: {noticia.data.autor_nome}</p>
                        </div>
                        <p className='my-8 text-justify'>
                            {noticia.data.conteudo}
                        </p>
                        <div className='flex justify-center'>
                            <img src={noticia.data.imagem_url} alt="" />
                        </div>
                        <p className='text-gray-500 text-end'>Categoria: {noticia.data.categoria}</p>
                    </div>
                </div>
            ) : (
                <p>Carregando notícia...</p>
            )}
        </>
    );
}

export default Slug;