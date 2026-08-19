import {useEffect, useState} from "react";
import {useStore} from "../store.jsx";
import {useNavigate, useParams} from "react-router-dom";
import SectionLink from "../components/reading/SectionLink.jsx";

const Reading = () => {

    const { chapterId, sectionId } = useParams();
    const { setCurrentPage, chapters, setCurrentSection, settings } = useStore()
    const navigate = useNavigate();

    const [chapter, setChapter] = useState({})
    const [section, setSection] = useState({})
    const [prev, setPrev] = useState(null)
    const [next, setNext] = useState(null)

    const [percent, setPercent] = useState(0)

    useEffect(() => {
        setCurrentPage("reading")

        if(chapters.length < 1)return

        let chapterIdx = chapters.findIndex(c => c.id === chapterId)
        let currChap = chapters[chapterIdx]
        setChapter(currChap)

        let sectionIdx = currChap.sections.findIndex(section => section.id === sectionId)
        setSection(currChap.sections[sectionIdx])
        setCurrentSection(currChap.sections[sectionIdx])

        if(sectionIdx > 0){
            setPrev(currChap?.sections[sectionIdx - 1]?.id)
        }else{
            setPrev(null)
        }

        if(sectionIdx < currChap.sections.length - 1){
            setNext(currChap?.sections[sectionIdx + 1]?.id)
        }else{
            setNext(null)
        }

        if(localStorage.getItem(sectionId) == null){
            localStorage.setItem(sectionId, 0.25)
        }

        let total = currChap?.sections?.length
        let amountRead = 0
        for(let i = 0; i < total; i++){
            if(isRead(currChap?.sections[i]?.id)){
                amountRead += 1
            }
        }
        setPercent((amountRead / total) * 100)
        console.log(total)
        console.log(amountRead)

    },[chapterId, sectionId, chapters])

    const goToPrev = () => {
        navigate(`/chapter/${chapterId}/section/${prev}`)
    }
    const goToNext = () => {
        navigate(`/chapter/${chapterId}/section/${next}`)
    }

    const isRead = (id) => {
        return localStorage.getItem(id) != null
    }

    return (
        <div>
            <div className={'progress rounded-0'}>
                <div className="progress-bar" style={{width:`${percent}%`}}></div>
            </div>
            <div className="container-fluid mt-2">
                <div className="row">
                    <div className="p-2 px-3 h-100 col-12 col-md-3" style={{backgroundColor: "lightgray",flex:"1"}}>
                        <div className={'fw-semibold'}>TABLE OF CONTENT</div>
                        <div className={'d-flex flex-column gap-2 mt-2'}>
                            {chapter?.sections?.map((section, i) => {
                                return <SectionLink section={section} key={i} chapterId={chapterId} isRead={isRead} sectionId={sectionId} i={i} />
                            })}
                        </div>
                    </div>
                    <div className="col-12 col-md-9 p-2 px-3 d-flex flex-column gap-2">
                        <small className={'text-secondary'}>Chapter {chapterId.replace("ch","")} - Section {sectionId.split("-")[1].replace("s","")} of {chapter.sections?.length}</small>
                        <div className={'fw-semibold fs-4'}>{section?.heading}</div>
                        <div
                            style={{
                                lineHeight:settings.spacing,
                                fontSize:settings.size,
                        }}
                        >
                            {section?.content}
                        </div>
                        {section?.image && <div>
                            <img src={`./${section?.image}`} alt={section?.imageAlt}/>
                        </div>}
                        <div className={'d-flex flex-column flex-sm-row justify-content-between align-items-center'}>
                            {prev ? <button onClick={goToPrev} className={'btn btn-outline-secondary'}>Previous Section</button> : <div></div>}
                            {next ? <button onClick={goToNext} className={'btn btn-outline-secondary'}>Next Section</button> : <div></div>}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    )
};export default Reading