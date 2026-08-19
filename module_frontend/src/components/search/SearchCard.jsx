import {useNavigate} from "react-router-dom";

const SearchCard = ({section, search}) => {

    const navigate = useNavigate();

    const sectionId = section.id.split("-")[1].replace("s","")
    const chapterId = section.id.split("-")[0].replace("ch","")

    const contentFound = section.content.indexOf(search)
    const headingFound = section.heading.indexOf(search)

    let highlight = ""
    if(headingFound >= 0){
        highlight = section.heading.slice(contentFound - 50, contentFound) + section.heading.slice(contentFound, contentFound + 50 )
    }else{
        highlight = section.content.slice(contentFound - 50, contentFound) + section.content.slice(contentFound, contentFound + 50 )
    }

    highlight =  `..${highlight.replaceAll(search, `<span style="background-color: yellow">${search}</span>`)}...`

    return (
        <button
            onClick={() => navigate(`/chapter/ch${chapterId}/section/ch${chapterId}-s${sectionId}`)}
            className={'card shadow text-start'}
        >
            <div className="card-body">
                <div className={'fw-semibold'}>
                    Chapter {chapterId} Section {sectionId}. {section.heading}
                </div>
                <small className={'text-secondary'} dangerouslySetInnerHTML={{__html: highlight}} />
            </div>
        </button>
    )
};export default SearchCard