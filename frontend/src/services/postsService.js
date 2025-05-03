export async function inserirPost(formulario, imagem) {
    const formData = new FormData;

    formData.append('titulo', formulario.titulo);
    formData.append('subtitulo', formulario.subtitulo);
    formData.append('conteudo', formulario.conteudo);
    formData.append('slug', formulario.slug);
    formData.append('autor_id', formulario.autor_id);
    formData.append('categoria', formulario.categoria);
    formData.append('imagem', imagem);

    const url = 'http://localhost:8080/api/posts/insertPost.php';
    try {
        const response = await fetch(url, {
            method: 'POST',
            body: formData,
        })
        const result = await response.json();
        // console.log(result);
        if (result) {
            // console.log(result.status);
            // console.log(result.message);
            return result;
        }
    } catch {
        return { 'status': 'error', 'message': 'Erro ao realizar a requisição', 'codigo': '' };
    }

}

export async function buscarNoticia(slugRecebido) {
    try {
        const formData = new FormData();
        formData.append('slug', slugRecebido);

        const url = 'http://localhost:8080/api/posts/buscarPorSlug.php';
        const response = await fetch(url, {
            method: 'POST',
            body: formData
        });
        const result = await response.json();
        if (result) {
            return result;
        } else {
            return {
                'status': 'error',
                'message': 'Erro ao receber a resposta',
                'codigo': ''
            };
        }
    } catch {
        return {
            'status': 'error',
            'message': 'Erro ao fazer a requisição',
            'codigo': ''
        }
    }
}

export async function listNews() {
    try {
        const url = 'http://localhost:8080/api/posts/listNews.php'
        const response = await fetch(url, {
            method: 'GET'
        })
        const result = response.json();
        if(result) {
            return result;
        }
    } catch {
        return {
            'status': 'error',
            'message': 'Requisição não executada',
            'codigo': ''
        }
    }
}

export async function atualizarPost(slug, formulario, imagem) {
    formulario.append('slug', slug);
    if (imagem) {
        formulario.append('imagem', imagem);
    }

    const url = 'http://localhost:8080/api/posts/editPost.php';   
    try {
        const response = await fetch(url, {
            method: 'POST',
            body: formulario,
        })
        const result = await response.json();
        console.log(result);
        if (result) {
            // console.log(result.status);
            // console.log(result.message);
            return result;
        }
    } catch {
        return { 'status': 'error', 'message': 'Erro ao realizar a requisição', 'codigo': '' };
    }
}