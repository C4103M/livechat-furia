import React from "react"
import styles from '../AoVivo.module.css'
function VideoCard(props) {
    return (
        <>
            <iframe width={props.width} height={props.height}
                src="https://www.youtube.com/embed/vFPo6WiBrXw?autoplay=1&modestbranding=1&rel=0&controls=0&showinfo=0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                referrerPolicy="strict-origin-when-cross-origin"
                allowFullScreen>
            </iframe>



        </>
    )
}

export default VideoCard;