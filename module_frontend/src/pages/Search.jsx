import {useEffect, useState} from "react";
import {useStore} from "../store.jsx";
import {useNavigate, useParams} from "react-router-dom";
import SearchCard from "../components/search/SearchCard.jsx";

const Search = () => {

    const { search, chapters } = useStore()
    const { query } = useParams()
    const navigate = useNavigate()
    const [sections, setSections] = useState([])

    useEffect(() => {
        if(search.trim() === '')return navigate('/')

        let temp = []
        for(let i = 0; i < chapters?.length; i++){
            temp = [...temp, ...chapters[i]?.sections]
        }
        temp = temp.filter(section => section.content.includes(search) || section.heading.includes(search))
        setSections(temp)

    },[search])

    const { setCurrentPage } = useStore()

    useEffect(() => {
        setCurrentPage("search")
    },[])

    return (
        <div className="d-flex flex-column gap-3 p-3">
            <div>Search the textbook: "{query}"</div>
            <div className="d-flex flex-column gap-3">
                {sections.length > 0 ? sections.map((section, i) => {
                    return <SearchCard search={search} key={i} section={section} />
                }) :
                    <div>
                        No results found.
                        Try another search term.
                    </div>
                }
            </div>
        </div>
    )
};export default Search