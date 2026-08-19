import {useStore} from "../store.jsx";
import {useNavigate} from "react-router-dom";
import {useEffect} from "react";

const SearchBar = () => {

    const { search, setSearch } = useStore()
    const navigate = useNavigate()

    const handleChange = e => {
        setSearch(e.target.value)
        navigate(`./search/${e.target.value}`)
    }

    return (
        <input
            value={search}
            onChange={handleChange}
            className={'form-control '}
            type="text"
            placeholder={"Search..."}
            aria-label="Search"
            aria-describedby="basic-search-bar"
        />
    )
};export default SearchBar