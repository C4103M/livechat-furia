export async function excluirConta(id) {
    const url = `http://localhost:8080/api/user/userDelete.php?id=${id}`;

    try {
        const response = await fetch(url, {
            method: 'GET',
        });
        const result = await response.json();
        return result;
    } catch (error) {
        console.error('Erro ao processar a exclusão da conta:', error);
        throw error; // relança o erro para o componente lidar
    }
}

export async function alterarNome(id, newName, senha) {
    const url = `http://localhost:8080/api/user/alterName.php?id=${id}&newName=${newName}&senha=${senha}`;
    // console.log(url);

    try {
        const response = await fetch(url, {
            method: 'GET',
        });
        const result = await response.json();
        if (result.status == 'sucess') {
            localStorage.setItem('token', result.token);
            console.log(result.status);
            console.log(result.message);
        }
    } catch (error) {
        console.error('Erro ao processar a alteração do nome:', error);
        throw error; // relança o erro para o componente lidar
    }
}
export async function alterarEmail(id, newEmail, senha) {
    const url = `http://localhost:8080/api/user/alterEmail.php?id=${id}&newEmail=${newEmail}&senha=${senha}`;
    try {
        const response = await fetch(url, {
            method: 'GET',
        });
        const result = await response.json();
        if (result.status == 'sucess') {
            localStorage.setItem('token', result.token); // Atualiza o token no localStorage
            console.log(result.status);
            console.log(result.message);
        }
    } catch (error) {
        console.error('Erro ao processar a alteração do nome:', error);
        throw error; // relança o erro para o componente lidar
    }
}
export async function alterarSenha(id, newSenha, senha) {
    const url = `http://localhost:8080/api/user/alterSenha.php?id=${id}&newPassword=${newSenha}&senha=${senha}`;
    try {
        const response = await fetch(url, {
            method: 'GET',
        });
        const result = await response.json();
        if (result.status == 'sucess') {
            localStorage.setItem('token', result.token); // Atualiza o token no localStorage
            console.log(result.status);
            console.log(result.message);

            return result; // Retorna o resultado para o componente lidar
        }
    } catch (error) {
        console.error('Erro ao processar a alteração do nome:', error);
        throw error; // relança o erro para o componente lidar
    }
}
export async function alterarFoto(id, formData) {
    const url = `http://localhost:8080/api/user/alterFoto.php`;

    formData.append('id', id);

    try {
        const response = await fetch(url, {
            method: 'POST',
            body: formData,
        });

        const result = await response.json();
        // const result = await response.text(); 
        // console.log(result); // Verifique o que está sendo retornado pela API

        if (result.status === 'success') {
            localStorage.setItem('token', result.token);
            console.log(result.status);
            console.log(result.message);
        } else {
            console.error('Erro da API:', result.message);
        }
    } catch (error) {
        console.error('Erro ao processar a alteração da foto:', error);
        throw error; // relança o erro para o componente lidar
    }
}

export async function ListUsers() {
    try {
        const url = 'http://localhost:8080/api/user/userList.php';
        const response = await fetch(url, {
            method: 'GET',
        });

        const data = await response.json(); // Extrair json
        return data;
    } catch (err) {
        console.error("Erro na requisição:", err); // bom para debugar
        return {
            status: 'error',
            message: 'Erro ao listar usuários',
            codigo: 500
        };
    }
}