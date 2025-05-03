import React, { useEffect, useState } from 'react';
import Input from '../../components/CreatePost/Input';
import Header from '../../components/Header/Header'
import * as postsService from '../../services/postsService';
import * as tokenDecode from '../../services/tokenDecode.js';
import { decodeToken } from '../../services/tokenDecode';
import Status from '../../components/Status/Status';
import { useNavigate } from 'react-router-dom';

function CreatePost() {
    
    const [decodedToken, setDecodedToken] = useState({});
    const [sended, isSended] = useState(false);
    const [statusEnvio, SetStatusEnvio] = useState({});
    const [formData, setFormData] = useState({
        titulo: '',
        subtitulo: '',
        categoria: '',
        slug: '',
        conteudo: '',
        autor_id: ''
    });
    const [imagem, setImagem] = useState(null);

    useEffect(() => {
        const token = localStorage.getItem('token');
        tokenDecode.isAdmin(token);
        if (token) {
            const decoded = decodeToken(token);
            setDecodedToken(decoded);
        }
    }, []);

    useEffect(() => {
        if (decodedToken && decodedToken.data) {
            // console.log('Token decodificado:', decodedToken.data.id);
            setFormData((prev) => ({
                ...prev,
                'autor_id': decodedToken.data.id
            }));
        }
        // if (sended && statusEnvio) {
        //     console.log(statusEnvio);
        // }
    }, [decodedToken, sended]);
    useEffect(() => {
        if (statusEnvio && sended) {
            console.log('status atualizado:', statusEnvio);
        }
    }, [statusEnvio]);
    


    const handleChange = (e) => {
        setFormData((prev) => ({
            ...prev,
            [e.target.name]: e.target.value
        }));
    };


    const handleFileChange = (e) => {
        const arquivo = e.target.files[0];
        setImagem(arquivo);
    };
    const handleSubmit = async (e) => {
        e.preventDefault();
        try {
            const response = await postsService.inserirPost(formData, imagem);
            SetStatusEnvio(response);
            isSended(true);
        } catch (error) {
            console.error('Erro ao enviar post:', error);
            SetStatusEnvio({
                status: 'error',
                message: 'Erro ao enviar post.',
                codigo: error.code || ''

            });
            isSended(true);
        }

    };




    return (
        <>
            <Header></Header>
            {sended && statusEnvio.status && statusEnvio.message && statusEnvio && (
                <Status
                    status={statusEnvio.status}
                    mensagem={statusEnvio.message}
                    codigo={statusEnvio.codigo || ''}
                />
            )}

            <form onSubmit={handleSubmit} className="w-full max-w-lg mx-auto mt-8 bg-gray-900 p-10 rounded-2xl border-2 border-[var(--main-border-color)]">
                <h1 className='text-center font-bold text-3xl mb-4'>Crie Sua notícia</h1>
                <Input
                    label="Título"
                    name="titulo"
                    value={formData.titulo}
                    onChange={handleChange}
                    placeholder="Digite o título da notícia"
                />
                <div className="mb-4">
                    <label htmlFor="subtitulo" className="mb-1 font-semibold block">Subtítulo/Resumo</label>
                    <textarea
                        id="subtitulo"
                        name="subtitulo"
                        value={formData.subtitulo}
                        onChange={handleChange}
                        placeholder="Escreva o resumo da notícia"
                        rows={2}
                        className="w-full border-2 border-[var(--main-border-color)] rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                </div>
                <div className="mb-4 flex flex-col">
                    <label htmlFor="imagem" className="mb-1 font-semibold">Imagem do Post</label>
                    <input type="file" name="imagem" id="imagem" onChange={handleFileChange} accept="image/*" />
                </div>
                <Input
                    label="Categoria"
                    name="categoria"
                    value={formData.categoria}
                    onChange={handleChange}
                    placeholder="Ex: CS2"
                />
                <Input
                    label="Slug (URL)"
                    name="slug"
                    value={formData.slug}
                    onChange={handleChange}
                    placeholder="ex: art-volta-ao-topo"
                />

                <div className="mb-4">
                    <label htmlFor="conteudo" className="mb-1 font-semibold block">Conteúdo</label>
                    <textarea
                        id="conteudo"
                        name="conteudo"
                        value={formData.conteudo}
                        onChange={handleChange}
                        placeholder="Escreva a notícia aqui..."
                        rows={5}
                        className="w-full border-2 border-[var(--main-border-color)] rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                </div>

                <button
                    type="submit"
                    className="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700"
                >
                    Publicar Postagem
                </button>
            </form>
        </>
    );
}

export default CreatePost;
