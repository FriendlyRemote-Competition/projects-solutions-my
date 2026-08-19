import {useStore} from "../store.jsx";
import {useEffect} from "react";

const NotFound = () => {

    const { setCurrentPage } = useStore()

    useEffect(() => {
        setCurrentPage("not found")
    },[])

    return (
        <div className="p-3">
            404 Not Found
        </div>
    )
};export default NotFound