import {createContext, useContext, useEffect, useState} from "react";

const StoreContext = createContext({})

export const StoreProvider = ({children}) => {

    const [book, setBook] = useState({})
    const [chapters, setChapters] = useState([])
    const [bookmarks, setBookmarks] = useState(JSON.parse(localStorage.getItem('bookmarks')) || [])
    const [search, setSearch] = useState('')
    const [currentPage, setCurrentPage] = useState("home")
    const [currentSection, setCurrentSection] = useState(null)
    const [panelOpen, setPanelOpen] = useState(false)
    const [settings, setSettings] = useState(JSON.parse(localStorage.getItem('settings')) || {
        size:"16px",
        spacing:"1.5",
        theme:"light"
    })

    useEffect(() => {
        localStorage.setItem('bookmarks', JSON.stringify(bookmarks))
    },[bookmarks])

    useEffect(() => {
        localStorage.setItem('settings', JSON.stringify(settings))
    }, [settings]);

    useEffect(() => {
        fetchData()
    },[])

    const fetchData = async () => {
        try{
            const res = await fetch("./data.json")
            const data = await res.json()
            console.log(data)

            setBook(data.book)
            setChapters(data.chapters)
        }catch(err){
            console.log(err)
        }
    }

    return (
        <StoreContext.Provider value={{
            book, setBook,
            chapters, setChapters,
            bookmarks, setBookmarks,
            search, setSearch,
            currentPage, setCurrentPage,
            currentSection, setCurrentSection,
            panelOpen, setPanelOpen,
            settings, setSettings
        }}>
            {children}
        </StoreContext.Provider>
    )
}

export const useStore = () => useContext(StoreContext)