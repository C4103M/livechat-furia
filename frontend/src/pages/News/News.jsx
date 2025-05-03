import React, { useEffect, useState } from 'react';

import * as postService from '../../services/postsService';
import Header from '../../components/Header/Header';
function News() {
    const [news, setNews] = useState([]);
    const [limiteNews, setLimiteNews] = useState(5);
    useEffect(() => {
        const getNews = async () => {
            try {
                let noticias = await postService.listNews();
                console.log('Estrutura de noticias:', noticias);

                if (Array.isArray(noticias.data)) {
                    // Caso seja um array, use diretamente
                    setNews(noticias.data);
                } else if (noticias.data) {
                    // Caso seja um único objeto, envolva em um array
                    setNews([noticias.data]);
                } else {
                    // Caso seja vazio ou inválido
                    setNews([]);
                    console.log('Nenhuma notícia encontrada.');
                }
            } catch (error) {
                console.error('Erro ao buscar notícias:', error);
            }
        };
        getNews();
    }, []);


    return (
        <>
            <Header />
            <div className='w-full h-full flex justify-center '>
                <div className='w-[40%] p-10 h-fit border-[var(--main-border-color)] border-2 rounded-2xl m-10 bg-gray-900'>
                    <h1 className='text-3xl font-extrabold mb-4' >Notícias mais relevantes</h1>
                    {news.length > 0 ? (
                        news.slice(0, limiteNews).map((noticia) => (
                            <div
                                key={noticia.id}
                                className="border rounded-xl shadow-md p-4 mb-6 flex flex-col md:flex-row gap-4 hover:shadow-lg transition-shadow duration-300 bg-gray-800"
                            >
                                {/* Imagem */}
                                {noticia.imagem_url && (
                                    <img
                                        src={noticia.imagem_url}
                                        alt={noticia.titulo}
                                        className="w-full md:w-48 h-32 object-cover rounded-md"
                                    />
                                )}

                                {/* Conteúdo */}
                                <div className="flex flex-col justify-between flex-1">
                                    <div>
                                        <h2 className="text-xl font-bold text-white">{noticia.titulo}</h2>
                                        {noticia.subtitulo && (
                                            <p className="text-gray-600 mt-2 text-sm line-clamp-3">
                                                {noticia.subtitulo}
                                            </p>
                                        )}
                                    </div>
                                    <div className="mt-3">
                                        <a
                                            href={`/noticias/${noticia.slug}`}
                                            className="text-blue-600 hover:underline text-sm font-medium"
                                        >
                                            Ler mais →
                                        </a>
                                    </div>
                                </div>
                            </div>
                        ))
                    ) : (
                        <p>Nenhuma notícia encontrada.</p>
                    )}

                </div>
            </div>
        </>
    );
}

export default News;