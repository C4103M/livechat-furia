import React, { useEffect, useState } from "react";

function Status({ status, mensagem, codigo }) {
    const [close, setClose] = useState(false);
    useEffect(() => {
        delayLoop();
    }, [])

    async function delayLoop() {
        let timming = 0;
        while (timming < 7) {
            await sleep(1000);
            timming++;
        }
        setClose(true);
    }
    function sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }
    function fechar() {
        setClose(true);
    }
    return (
        <>
            {/* Overlay desfocado */}
            <div className={`fixed inset-0 backdrop-blur-sm bg-black/30 z-10 ${close ? "hidden" : ""}`}></div>

            {/* Card centralizado */}
            <div
                className={`w-[30%] h-fit border-2 border-white 
                rounded-lg fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 
                ${status === "success" ? "bg-green-300" : "bg-red-300"} p-5 z-20
                ${close ? "hidden" : ""}`}
            >
                <i className="fa-solid fa-xmark absolute top-4 right-4 scale-[1.7]" onClick={fechar}></i>
                <p className="text-3xl font-bold text-gray-300">
                    Status: {status.charAt(0).toUpperCase() + status.slice(1)}
                </p>
                <hr className="w-full my-3" />
                <p className="text-lg text-gray-300">Mensagem: {mensagem}</p>
                <hr className="w-[90%] my-3" />
                <p className="text-lg text-gray-300">Código: {codigo}</p>
            </div>
        </>
    );
}

export default Status;
