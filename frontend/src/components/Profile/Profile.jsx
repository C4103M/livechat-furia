import React, { useEffect, useState } from 'react';
import { useNavigate } from 'react-router-dom';
import profileDefault from '../../assets/profile-default.png';
// import jwt_decode from "jwt-decode";
import jwtDecode from 'jwt-decode';
function Profile() {
    const navigate = useNavigate();
    const [loged, isLoged] = useState(false);
    const [dados, setDados] = useState({});
    const [fotoPerfil, setFotoPerfil] = useState(profileDefault);
    useEffect(() => {
        const token = localStorage.getItem('token');
        if (token) {
            isLoged(true);
            setDados(jwtDecode(token));
        } else {
            isLoged(false);
        }
    }, []);
    useEffect(() => {
        if (dados && dados.data && dados.data.foto != null) {
            setFotoPerfil(dados.data.foto);
        }
    }, [dados]);

    const handleLoginClick = () => {
        navigate('/login');
    };
    const handleConfigClick = () => {
        navigate('/config');
    };

    return (
        <>
            <div className="strokeText flex align-center flex-col gap-4 w-[100%]">
                <div className="flex align-center gap-10 w-[40%] min-w-[300px]">
                    <div className="w-[100%] h-fit border-2 border-[var(--main-border-color)] rounded-lg p-4 bg-gray-800">
                        <div className="flex justify-start gap-20">
                            <div className="w-[80px] h-[80px] aspect-square overflow-hidden rounded-full border-2 border-[var(--main-border-color)]  flex justify-center items-center bg-gray-800">
                                <img src={fotoPerfil} alt="Perfil" className="w-full h-full" />
                            </div>
                            <div className="mt-3">
                                {/* {fotoPerfil} */}
                                <p className="text-[25px] font-semibold text-justify">
                                    {loged ? dados.data.nome : 'Anônimo'}
                                </p>
                                <p className="text-[18px] font-light text-justify mt-1.5 italic">
                                    {loged ? dados.data.email : 'Você não está logado'}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Só aparece o botão se não estiver logado */}
                {!loged && (
                    <div className="btn w-[40%]">
                        <button onClick={handleLoginClick} className="bg-purple-950 text-white font-bold py-2 px-4 rounded w-full min-w-[300px]">
                            Login
                        </button>
                    </div>
                )}
                {loged && (
                    <div className="btn w-[40%]">
                        <button onClick={handleConfigClick} className="bg-purple-950 text-white font-bold py-2 px-4 rounded w-full min-w-[300px]">
                            Configurações
                        </button>
                    </div>
                )}
            </div>
        </>
    );
};

export default Profile;
