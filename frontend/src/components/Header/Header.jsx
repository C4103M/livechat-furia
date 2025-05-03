import { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import logo from '../../assets/furia-logo.png';
import * as tokenDecode from '../../services/tokenDecode.js';

function Header() {
    const [decoded, setDecoded] = useState({});
    const [menuAberto, setMenuAberto] = useState(false);

    useEffect(() => {
        const token = localStorage.getItem('token');
        if (token) {
            try {
                const tempToken = tokenDecode.decodeToken(token);
                setDecoded(tempToken);
            } catch (error) {
                console.error('Erro ao decodificar o token:', error);
            }
        }
    }, []);

    function redirectHome() {
        window.location.href = '/';
    }

    function toggleMenu() {
        setMenuAberto(prev => !prev);
    }

    return (
        <>
            <header className="w-full p-3 flex justify-between items-center bg-gradient-to-b from-[#000] via-[#010309] to-[#030712] relative">
                {/* Logo + Título */}
                <div className="flex items-center">
                    <img src={logo} alt="FURIA LOGO" className="h-[3em] m-[15px] p-[.5em]" />
                    <h1 className="text-[1.5em] m-4 p-[.4em] cursor-pointer" onClick={redirectHome}>
                        FURIA CHAT
                    </h1>
                </div>

                {/* Botão hamburguer visível apenas em telas pequenas */}
                <button 
                    onClick={toggleMenu}
                    className="lg:hidden text-white text-3xl mr-4"
                >
                    ☰
                </button>

                {/* Menu de navegação */}
                <nav className={`absolute top-full left-0 w-full bg-[#030712] lg:bg-transparent lg:static lg:w-auto lg:flex lg:items-center transition-all duration-300 z-10 ${menuAberto ? 'block' : 'hidden'} lg:block`}>
                    <div className="flex flex-col lg:flex-row lg:space-x-6 text-white p-4 lg:p-0 mr-30">
                        <Link to="/" className="py-2 link">AoVivo</Link>
                        <Link to="/news" className="py-2 link">Notícias</Link>
                        <Link to="/config" className="py-2 link">Configurações</Link>
                        {decoded.data && decoded.data.isAdmin == 1 && (
                            <Link to="/admin" className="py-2 link">Admin</Link>
                        )}
                    </div>
                </nav>
            </header>
        </>
    );
}

export default Header;
