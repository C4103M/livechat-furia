export async function buscarConversa(remetente_id, destinatario_id) {
    const formData = new FormData;
    formData.append('destinatario_id' ,destinatario_id);
    formData.append('remetente_id' ,remetente_id);
    try {
        const url = "http://localhost:8080/api/message/buscarConversa.php";
        const response = await fetch(url, {
            method: 'POST',
            body: formData
        });
        const result = await response.json();   
        return result;
    } catch {
        console.log('Erro na requisição');
    }
}
export async function enviarMensagem(remetente_id, destinatario_id, conteudo) {
    const formData = new FormData;
    formData.append('destinatario_id', destinatario_id);
    formData.append('remetente_id', remetente_id);
    formData.append('conteudo', conteudo);

    try {
        const url = "http://localhost:8080/api/message/enviarMensagem.php";
        const response = await fetch(url, {
            method: 'POST',
            body: formData
        });

        const result = response.json();
        return result;
    } catch {
        console.log("Erro na requisição");
    }
}
