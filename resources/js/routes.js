// Route views
import LibraryView from './views/LibraryView'
import SearchView from './views/SearchView'
import GameView from './views/GameView'

// Routes
export default [
	{
		path: '/',
		component: LibraryView,
		name: 'library',
	},
	{
		path: '/search/:query',
		component: SearchView,
		name: 'search',
	},
	{
		path: '/games/:slug',
		component: GameView,
		name: 'game',
	},
]
