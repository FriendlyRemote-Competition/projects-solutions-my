import {useStore} from "../store.jsx";
import {useEffect} from "react";
import BookmarkCard from "../components/bookmarks/BookmarkCard.jsx";

const Bookmarks = () => {

    const { setCurrentPage, bookmarks } = useStore()

    useEffect(() => {
        setCurrentPage("bookmarks")
    },[])


    return (
        <div className="container-fluid p-2 px-3">
            <div className={'fw-semibold fs-3'}>My bookmarks ({bookmarks?.length})</div>
            <div className={'d-flex flex-column gap-3 mt-2'}>
                {bookmarks?.length > 0 ? bookmarks?.map((bookmark,i) => {
                    return <BookmarkCard bookmark={bookmark} key={i}/>
                })
                :
                <div>
                    You don't have any bookmarks yet.
                    Add a bookmark by clicking 'Bookmark' while reading a section
                </div>
                }
            </div>
        </div>
    )
};export default Bookmarks