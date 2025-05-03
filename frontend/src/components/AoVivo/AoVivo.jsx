import React from "react";
import VideoCard from "./compontents/VideoCard";
import VideoChat from "./compontents/videoChat";
import ChatBoot from "./compontents/ChatBoot";
import styles from "./AoVivo.module.css"
function AoVivo() {
    return (
        <>
            <div className="w-[100%] h-[50%] flex justify-center">
                <div className={`${styles.principal} w-[97%] h-fit p-11 border-3 flex items-center justify-around border-[var(--main-border-color)] rounded-3xl bg-gray-900 gap-5 `}>
                    <div className={`${styles.tam1} overflow-hidden rounded-4xl ml-7`}>
                        <VideoCard width='560' height='315' />
                    </div>
                    <div className={`${styles.tam2} overflow-hidden rounded-4xl ml-7`}>
                        <VideoCard width='300' height='168' />
                    </div>
                    <VideoChat/>
                </div>
            </div>
        </>
    )
}

export default AoVivo;