import { useState } from 'react'
import './App.css'
import { BrowserRouter, Routes, Route } from 'react-router-dom'
import Home from './pages/Home/Home.jsx'
import Login from './pages/Login/Login.jsx'
import Config from './pages/Config/Config.jsx'
import Admin from './pages/Admin/Admin.jsx'
import News from './pages/News/News.jsx'
import CreatePost from './pages/Admin/CreatePost.jsx'
import PostDetalhado from './pages/News/Slug.jsx'
import Chat from './pages/Chat/Chat.jsx'
import Moderate from './pages/Admin/Moderate.jsx'
import EditPost from './pages/Admin/EditPost.jsx'
import EditPostExpand from './pages/Admin/EditPostExpand.jsx'
function App() {
	const [count, setCount] = useState(0)

	return (
		<>
			<BrowserRouter>
				<Routes>
					<Route path="/" element={<Home />}/>
					<Route path="/login" element={<Login />} />
					<Route path="/config" element={<Config />} />
					<Route path="/admin" element={<Admin />} />
					<Route path="/news" element={<News />} />
					<Route path="/noticias" element={<News />} />
					<Route path="/noticias/:slug" element={<PostDetalhado />} />
					<Route path="/news/:slug" element={<PostDetalhado />} />
					<Route path="/create" element={<CreatePost />} />
					<Route path="/moderate" element={<Moderate/>} />
					<Route path="/editPosts" element={<EditPost/>}/>
					<Route path="/edit/:slug" element={<EditPostExpand />} />
					<Route path="/chat/:user_id" element={<Chat />} />
				</Routes>
			</BrowserRouter>
		</>
	)
}

export default App
