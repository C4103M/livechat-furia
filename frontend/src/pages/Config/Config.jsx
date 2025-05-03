import React, { useEffect, useState } from 'react';
import { useNavigate } from 'react-router-dom';
import Header from '../../components/Header/Header';
import profileDefault from '../../assets/profile-default.png';
import CardFuria from '../../components/CardFuria.jsx';
import FormAlterarNome from '../../components/configPage/FormChangeName.jsx';
import FormAlterarEmail from '../../components/configPage/FormChangeEmail.jsx';
import FormAlterarSenha from '../../components/configPage/FormChangePassword.jsx';
import FormAlterarFoto from '../../components/configPage/FormChangePhoto.jsx';
import * as authService from '../../services/authService.js';
import { decodeToken, isTokenExpired } from '../../services/tokenDecode.js';

function Config() {
    const navigate = useNavigate();

    const [loged, isLoged] = useState(false);
    const [dados, setDados] = useState({});
    const [userImg, setUserImg] = useState(profileDefault);
    const [toogle, setToogle] = useState(false);

    useEffect(() => {
        const token = localStorage.getItem('token');
        if (token) {
            const decoded = decodeToken(token);
            isTokenExpired(token);
            setDados(decoded.data);
            isLoged(true);
            if (decoded.data && decoded.data.foto) {
                setUserImg(decoded.data.foto);
            }
        } else {
            isLoged(false);
            navigate('/');
        }


    }, [navigate]);
    function mudarToogle() {
        setToogle((prev) => !prev);
    }
    function logOff() {
        localStorage.removeItem('token');
        navigate('/login');
    };
    const handleAlterarNome = (novoNome, senha) => {
        authService.alterarNome(dados.id, novoNome, senha); // Chama o serviço com os dados
    };

    return (
        <>
            <Header />
            <div className="flex w-full justify-center gap-4">
                {/* Card Principal */}
                <div className={`tg1 align-center flex-col gap-4 w-[420px] bg-gray-800 border-2
                     border-[var(--main-border-color)] rounded-lg p-4 transition-all duration-500 ease-in-out ${toogle ? 'hidden' : 'flex'}`}>
                    <h1 className="font-extrabold text-4xl m-auto mb-[30px]">Configurações</h1>

                    <FormAlterarNome onSubmit={(novoNome, senha) => {
                        authService.alterarNome(dados.id, novoNome, senha); // Chama o serviço com os dados
                    }} />
                    <FormAlterarEmail onSubmit={(novoEmail, senha) => {
                        authService.alterarEmail(dados.id, novoEmail, senha); // Chama o serviço com os dados
                    }} />
                    <FormAlterarSenha onSubmit={(novaSenha, senha) => {
                        authService.alterarSenha(dados.id, novaSenha, senha); // Chama o serviço com os dados
                    }} />

                    <button onClick={mudarToogle}>Mais opções</button>
                </div>

                {/* Card de Foto e Opções */}
                <div className={`tg1 align-center flex-col gap-4 w-[420px] bg-gray-800 border-2
                     border-[var(--main-border-color)] rounded-lg p-4 transition-all duration-500 ease-in-out ${toogle ? 'flex' : 'hidden'}`}>

                    <FormAlterarFoto
                        userImg={userImg}
                        onSubmit={(novaFoto) => {
                            const formData = new FormData();
                            formData.append('foto', novaFoto);

                            authService.alterarFoto(dados.id, formData)
                                .then((result) => {
                                    console.log('Foto alterada com sucesso:', result);
                                })
                                .catch((error) => {
                                    console.error('Erro ao alterar a foto:', error);
                                });
                        }}
                    />

                    <button onClick={logOff}>Sair</button>
                    <button onClick={authService.excluirConta}>Excluir Conta</button>

                    <CardFuria />

                    <button onClick={mudarToogle}>Mais opções</button>
                </div>
            </div>
        </>
    );
}

export default Config;


