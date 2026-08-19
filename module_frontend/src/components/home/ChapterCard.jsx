import {useNavigate} from "react-router-dom";
import {useEffect, useState} from "react";

const ChapterCard = ({chapter}) => {
    const navigate = useNavigate()
    const [percent, setPercent] = useState(0)
    const goTo = (chapterId, sectionId) => {
        navigate(`/chapter/${chapterId}/section/${sectionId}`)
    }

    useEffect(() => {
        let total = chapter.sections.length
        let amountRead = 0
        for(let i = 0; i < total; i++){
            if(isRead(chapter.sections[i].id)){
                amountRead++
            }
        }
        setPercent((amountRead/total) * 100)
    },[])

    const isRead = (id) => {
        return localStorage.getItem(id) != null
    }

    return (
        <div className={'card shadow'}>
            <div className="card-body d-flex flex-column flex-sm-row align-items-center justify-content-between gap-3">
                <div className={'d-flex flex-column gap-2 flex-grow-1'}>
                    <div className={'fw-semibold'}>Chapter {chapter.number}. {chapter.title}</div>
                    <div className={'progress'}>
                        <div className="progress-bar" style={{width:`${percent}%`}}></div>
                    </div>
                    <small>{chapter.sections[0]?.heading}</small>
                </div>
                <div>
                    <button onClick={() => goTo(chapter.id, chapter.sections[0].id)} className={'btn btn-secondary w-100'}>
                        &#10097;
                    </button>
                </div>
            </div>
        </div>
    )
};export default ChapterCard