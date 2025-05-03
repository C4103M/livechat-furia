import React, { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import Header from "../../components/Header/Header";
import Status from "../../components/Status/Status"
import profileDefault from "../../assets/profile-default.png"
import * as authService from '../../services/authService'
import * as tokenDecode from '../../services/tokenDecode'

function Moderate() {
    const navigate = useNavigate();

    const [usuarios, setUsuarios] = useState({});
    const [statusInfo, setStatusInfo] = useState(null);
    const [decodedToken, setDecodedToken] = useState({})
    useEffect(() => {
        const token = localStorage.getItem('token');
        tokenDecode.isAdmin(token);
        let tk = tokenDecode.decodeToken(token);
        if (tk && tk.data) {
            setDecodedToken(tk);
        }
        const fetchUsuarios = async () => {
            try {
                const resposta = await authService.ListUsers(); // Assumindo que retorna um array ou objeto com os usuários
                // console.log(resposta);
                if (Array.isArray(resposta)) {
                    setUsuarios(resposta); // Caso seja um array diretamente
                }
            } catch (error) {
                console.error("Erro ao carregar usuários:", error);
            }
        };
        fetchUsuarios();
    }, []);
    // useEffect(() => {
    //     if (decodedToken && decodedToken.data && decodedToken.data.isAdmin != 1) {
    //         navigate('/');
    //     }
    // }, [decodedToken]);

    const delUser = async (id) => {
        try {
            console.log("Ta chegando no try");
            const deletar = await authService.excluirConta(id);
            if (deletar.status == 'success') {
                setStatusInfo({
                    status: deletar.status,
                    mensagem: deletar.message,
                    codigo: deletar.codigo,
                });
                window.location.reload()
            }
        } catch {
            console.error("Erro ao deletar usuário:", error);
        }
    }

    return (
        <>
            <Header></Header>
            {statusInfo && (
                <Status
                    status={statusInfo.status}
                    mensagem={statusInfo.mensagem}
                    codigo={statusInfo.codigo}
                />
            )}
            <div className="w-full flex justify-center">
                <div className="trokeText w-[40%] h-fit border-2 border-[var(--main-border-color)] rounded-lg p-4 bg-gray-800 z-2 mb-10">
                    <h1 className="text-center font-bold text-2xl mt-2 mb-10">Controle Aqui a Moderação de usuários</h1>
                    <div className={`w-[100%] flex flex-col justify-center transition-all duration-500 ease-in-out overflow-hidden opacity-100 mt-2 `}>
                        {Array.isArray(usuarios) && (usuarios.slice().map(usuario => (
                            <div key={usuario.id} className='w-[100%] h-fit flex gap-10 justify-between items-center border-2 border-[var(--main-border-color)] rounded-lg p-4 bg-gray-900 mt-2'>
                                <div className='flex gap-5 items-center'>
                                    <div className='w-15 rounded-full aspect-square overflow-hidden border-2 border-[var(--main-border-color)] flex justify-center items-center bg-gray-800'>
                                        <img src={usuario.img ? usuario.img : profileDefault} alt="Perfil" />

                                    </div>
                                    <p className='font-medium text-lg'>{usuario.name}</p>
                                    {/* {usuario.img} */}
                                </div>
                                <button onClick={() => delUser(usuario.id)}>
                                    <i className="fa-solid fa-trash"  ></i>
                                </button>
                            </div>
                        )))}
                    </div>
                </div>
            </div>
        </>
    )
}

export default Moderate