import React, { useEffect } from "react";
import { Link } from "react-router-dom";
import Header from "../../components/Header/Header";
import * as tokenDecode from '../../services/tokenDecode'
function Admin() {
    useEffect(() => {
        const token = localStorage.getItem('token');
        tokenDecode.isAdmin(token);
    }, [])

    return (
        <>
            <Header />
            <div className="w-full flex justify-center">
                <div className="w=[40%] flex gap-10 mt-30">
                    <Link to='/moderate' className='link'>
                        <div className="border-2 p-10 rounded-2xl ">
                            Moderação de Usuários
                        </div>
                    </Link>
                    <Link to='/editPosts' className="link">
                        <div className="border-2 p-10 rounded-2xl">
                            Gerenciar Posts
                        </div>
                    </Link>
                    <Link to='/create' className="link">
                        <div className="border-2 p-10 rounded-2xl">
                            Criar Publicações
                        </div>
                    </Link>
                </div>
            </div>
        </>
    )
}

export default Admin;