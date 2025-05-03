import React, { useEffect, useState } from 'react';
import { useParams } from 'react-router-dom';
import * as postService from '../../services/postsService';
import Header from '../../components/Header/Header';
import Input from '../../components/CreatePost/Input2';
import Status from '../../components/Status/Status';
function EditPostExpand() {
    const { slug } = useParams();
    const [noticia, setNoticia] = useState({});
    const [visibleContent, setVisibleContent] = useState(false);
    const [status, setStatus] = useState({});
    const [formData, setFormData] = useState({
        titulo: '',
        subtitulo: '',
        conteudo: '',
        categoria: '',
    });
    const [imagem, setImagem] = useState(null);

    const handleInputChange = (e) => {
        const { name, value } = e.target;
        setFormData({
            ...formData,
            [name]: value,
        });
    };

    const handleImageChange = (e) => {
        setImagem(e.target.files[0]);
    };

    useEffect(() => {
        const fetchNoticia = async () => {
            try {
                const responseNoticia = await postService.buscarNoticia(slug);
                setNoticia(responseNoticia);
            } catch (error) {
                console.error('Erro ao buscar notícia:', error);
            }
        };
        fetchNoticia();
    }, [slug]);

    useEffect(() => {
        if (noticia && noticia.data) {
            setFormData({
                titulo: noticia.data.titulo || '',
                subtitulo: noticia.data.subtitulo || '',
                conteudo: noticia.data.conteudo || '',
                categoria: noticia.data.categoria || '',
            });
            setVisibleContent(true);
        }
    }, [noticia]);

    const handleSubmit = async (e) => {
        e.preventDefault();
        try {
            const formDataToSend = new FormData();
            formDataToSend.append('titulo', formData.titulo);
            formDataToSend.append('subtitulo', formData.subtitulo);
            formDataToSend.append('conteudo', formData.conteudo);
            formDataToSend.append('categoria', formData.categoria);
            

            const response = await postService.atualizarPost(slug, formDataToSend, imagem);
            const result = response;
            if(result) {
                setStatus(result);
            }
            // console.log('Post atualizado com sucesso:', response);
        } catch (error) {
            console.error('Erro ao atualizar o post:', error);
        }
    };

    return (
        <>
            <Header />
            {status && status.status && status.message ? <Status status={status.status} mensagem={status.message} codigo={status.codigo}/> : ''}

            <div className="w-full flex justify-center">
                <div className="w-[40%] border-2 rounded-2xl">
                    {visibleContent ? (
                        <div className="p-10">
                            <h1 className="text-3xl font-bold mb-6">Editar Post</h1>
                            <form onSubmit={handleSubmit} className="flex flex-col gap-4">
                                <Input
                                    label="Título"
                                    type="text"
                                    name="titulo"
                                    value={formData.titulo}
                                    onChange={handleInputChange}
                                />
                                <Input
                                    label="Subtítulo"
                                    type="text"
                                    name="subtitulo"
                                    value={formData.subtitulo}
                                    onChange={handleInputChange}
                                />
                                <div className="flex flex-col">
                                    <label className="font-medium mb-2">Conteúdo</label>
                                    <textarea
                                        rows="10"
                                        name="conteudo"
                                        value={formData.conteudo}
                                        onChange={handleInputChange}
                                        className="border rounded p-2"
                                    />
                                </div>
                                <Input
                                    label="Categoria"
                                    type="text"
                                    name="categoria"
                                    value={formData.categoria}
                                    onChange={handleInputChange}
                                />
                                <div className="flex flex-col">
                                    <label className="font-medium mb-2">Imagem</label>
                                    <input
                                        type="file"
                                        accept="image/*"
                                        className="border-2 rounded p-2 border-[var(--main-border-color)]"
                                        onChange={handleImageChange}
                                    />
                                </div>
                                <button
                                    type="submit"
                                    className="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                                >
                                    Salvar Alterações
                                </button>
                            </form>
                        </div>
                    ) : (
                        <p>Carregando notícia...</p>
                    )}
                </div>
            </div>
        </>
    );
}

export default EditPostExpand;