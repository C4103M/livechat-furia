import jwtDecode from 'jwt-decode';
export function decodeToken(token) {
    try {
        const decoded = jwtDecode(token);
        console.log(decoded);
        return decoded;
    } catch (error) {
        console.error('Error decoding token:', error);
        return null;
    }
}

export function isTokenExpired(token) {
    const decoded = decodeToken(token);
    if (decoded) {
        const currentTime = Date.now() / 1000;
        if(decoded.exp < currentTime) {
            window.localStorage.removeItem('token');
            window.location.href = '/login';
        }
    }
}

export function isAdmin(token) {
    const decoded = decodeToken(token);
    if(decoded) {
        console.log(decoded.data.isAdmin);
        
        if(decoded.data.isAdmin != 1) {
            window.location.href = '/login';
        }
    }
}

// export function isLoged(token) {
//     const decoded = decodeToken(token);
//     if(decoded) {
        

//     }
// }