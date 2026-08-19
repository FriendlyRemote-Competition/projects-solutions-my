import {useStore} from "../store.jsx";
import ChapterCard from "../components/home/ChapterCard.jsx";
import {useEffect, useState} from "react";

const Home = () => {

    const { chapters, setCurrentPage } = useStore()
    const [percent, setPercent] = useState(0)

    useEffect(() => {
        setCurrentPage("home")

        let total = chapters.length
        let chaptersRead = 0
        for (let i = 0; i < chapters.length; i++) {
            let chapterAmount = 0;
            let chapterTotal = chapters[i].sections.length
            for (let j = 0; j < chapterTotal; j++) {
                if(isRead(chapters[i].sections[j].id)) {
                    chapterAmount++
                }
            }
            chaptersRead += (chapterAmount / chapterTotal)
        }
        setPercent((chaptersRead / total) * 100)

    },[])

    const isRead = (id) => {
        return localStorage.getItem(id) != null
    }

    return (
        <div>
            <div className={'progress rounded-0'}>
                <div className="progress-bar" style={{width:`${percent}%`}}></div>
            </div>
            <div className="d-flex flex-column gap-3 container-fluid p-3">
                {chapters.map((chapter, i) => {
                    return <ChapterCard chapter={chapter} key={i} />
                })}
            </div>
        </div>
    )
};export default Home