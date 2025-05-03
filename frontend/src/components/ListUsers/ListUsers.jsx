import React, { useState, useEffect } from 'react';
import profileDefault from '../../assets/profile-default.png';
import jwtDecode from 'jwt-decode';
import * as authService from '../../services/authService.js';
function ListUsers() {
    const [isExpanded, setIsExpanded] = useState(false);
    const [usuarios, setUsuarios] = useState([]);
    const [limiteUsuarios, setLimiteUsuarios] = useState(3);

    const [loged, isLoged] = useState(false);
    const [dados, setDados] = useState({});

    const toggleExpand = () => {
        setIsExpanded((prev) => !prev);
    };
    const mostrarMais = () => {
        setLimiteUsuarios(limiteUsuarios + 3);
    };
    useEffect(() => {
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

        const token = localStorage.getItem('token');
        if (token) {
            isLoged(true);
            setDados(jwtDecode(token));
            // console.log(jwtDecode(token));

        } else {
            isLoged(false);
        }
    }, [])
    return (
        <>
            <div className='strokeText w-[40%] h-fit border-2 border-[var(--main-border-color)] rounded-lg p-4 bg-gray-800 z-2 min-w-[300px]'>
                <div className='flex justify-between items-center w-full'>
                    <p className='font-medium'>Outros Usuários</p>
                    <button id='expandBtn' onClick={toggleExpand}>
                        <i className={`icnExpand fa-solid transition-transform duration-300 ${isExpanded ? 'fa-chevron-up' : 'fa-chevron-down'}`}></i>
                    </button>
                </div>

                <div className={`w-[100%] flex flex-col justify-center transition-all duration-500 ease-in-out overflow-hidden ${isExpanded ? 'max-h-96 opacity-100 mt-2 overflow-y-scroll' : 'max-h-0 opacity-0'}`}>
                    {loged && Array.isArray(usuarios) &&  (usuarios.slice(0, limiteUsuarios).map(usuario => (
                        <div key={usuario.id} className='w-[100%] h-fit flex gap-10 justify-between items-center border-2 border-[var(--main-border-color)] rounded-lg p-4 bg-gray-900 mt-2'>
                            <div className='flex gap-5 items-center'>
                                <div className='w-15 rounded-full aspect-square overflow-hidden border-2 border-[var(--main-border-color)] flex justify-center items-center bg-gray-800'>
                                    <img src={usuario.img ? usuario.img : profileDefault} alt="Perfil"  />

                                </div>
                                <p className='font-medium text-lg'>{usuario.name}</p>
                                {/* {usuario.img} */}
                            </div>
                            {/* <button>
                                <i className="fa-regular fa-comment scale-[1.5]"></i>
                            </button> */}
                        </div>
                    )))}
                    {!loged && (<p>Faça Log-in para conversar com outros usuários</p>)}

                    <div>
                        {loged && limiteUsuarios < usuarios.length && (
                            <h4 className='text-right' onClick={mostrarMais}>Ver mais...</h4>
                        )}
                    </div>
                </div>
            </div>

        </>
    );
};

export default ListUsers;