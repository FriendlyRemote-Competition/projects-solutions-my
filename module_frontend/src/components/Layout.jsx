import {useStore} from "../store.jsx";
import {Link, useParams} from "react-router-dom";
import SearchBar from "./Searchbar.jsx";

const Layout = ({ children }) => {

    const { book, currentPage, currentSection, setBookmarks, bookmarks, setPanelOpen } = useStore()
    const bookmark = () => {
        let temp = [...bookmarks]
        let idx = temp.findIndex(b => b.id === currentSection.id)
        if(idx < 0){
            temp.push(currentSection)
        }else{
            temp.splice(idx, 1)
        }
        setBookmarks(temp)
    }

    const isBookmarked = () => {
        console.log(bookmarks?.findIndex(b => b.id === currentSection?.id))
        return bookmarks?.findIndex(b => b.id === currentSection?.id) > -1
    }

    return (
        <div>
            <header
                className={'bg-dark p-2 px-3 text-white d-flex flex-column flex-sm-row gap-2 justify-content-between align-items-center'}
            >
                <div>
                    { (currentPage === 'home' || currentPage === 'bookmarks' || currentPage === 'search') && <Link to={'/'} className={'text-white text-decoration-none'}>{book.title}</Link>}
                    { currentPage === 'reading' && <Link to={'/'} className={'text-white text-decoration-none'}>&#10096; Library</Link>}
                </div>
                <div className={'d-flex gap-2 align-items-center'}>
                    {(currentPage === "home" || currentPage === 'search') && <Link to={'/bookmarks'} className={'btn btn-warning'}>Bookmarks</Link>}
                    <SearchBar/>
                    {currentPage === "reading" &&
                        <button onClick={bookmark} className={`btn ${isBookmarked() ? "btn-outline-warning" : "btn-warning"}`}>
                            {isBookmarked() ? "Bookmarked" :  "Bookmark"}
                        </button>
                    }
                    <button onClick={() => setPanelOpen(true)} className={'btn btn-secondary'}>
                        Settings
                    </button>
                </div>
            </header>
            <main>{children}</main>
            <footer>
              <small className={'text-secondary'}>&copy; {new Date().getFullYear()} Digital Textbook</small>
            </footer>
        </div>
    )
};export default Layout