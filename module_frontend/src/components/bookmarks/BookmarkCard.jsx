import {useNavigate} from "react-router-dom";
import {useStore} from "../../store.jsx";

const BookmarkCard = ({bookmark}) => {

    const navigate = useNavigate();
    const { setBookmarks, bookmarks } = useStore()

    const goTo = () => {
        console.log("goTo")
        navigate(`/chapter/${bookmark?.id.split("-")[0]}/section/${bookmark?.id}`)
    }

    const removeBookmark = () => {
        let temp = [...bookmarks]
        temp = temp.filter(item => item.id !== bookmark.id)
        setBookmarks(temp)
    }

    return (
        <div className={'card shadow-sm'}>
            <div className="card-body d-flex flex-column flex-sm-row gap-2 align-items-center justify-content-between">
                <div>
                    Chapter {bookmark?.id.split("-")[0].replace("ch","")} -
                    Section {bookmark?.id.split("-")[1].replace("s","")}
                </div>
                <div className={'d-flex gap-2'}>
                    <button onClick={goTo} className={'btn btn-outline-secondary'}>Go to</button>
                    <button onClick={removeBookmark} className={'btn btn-outline-danger'}>Remove</button>
                </div>
            </div>
        </div>
    )
};export default BookmarkCard