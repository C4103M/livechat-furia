# Use the official Node.js image as the base image
FROM node:18-alpine

# Diretório de trabalho dentro do container
WORKDIR /app

# Copiar package.json e package-lock.json
COPY package*.json ./

# Instala as dependências
RUN npm install

# Copia os demais arquivos
COPY . .

# Expõe a porta padrão do Vite
EXPOSE 5173

# Comando padrão para iniciar o servidor dev
CMD ["npm", "run", "dev"]
