import { useState } from 'react'
import Header from '../../components/Header/Header.jsx'
import Profile from '../../components/Profile/Profile.jsx'
import ListUsers from '../../components/ListUsers/ListUsers.jsx'
import AoVivo from '../../components/AoVivo/AoVivo.jsx'
function Home() {

	return (
		<>
			<Header />
			<div className='w-full flex justify-center p-5 mb-10'>
				<div className="w-[90%] flex justify-center flex-col lg:flex-row md:flex-between">
					<Profile></Profile>
					<ListUsers ></ListUsers>
				</div>
			</div>
			<div className='m-auto w-[90vw] flex justify-center'>
				<AoVivo></AoVivo>
			</div>
		</>
	)
}

export default Home
