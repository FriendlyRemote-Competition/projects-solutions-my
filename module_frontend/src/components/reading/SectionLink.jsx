import {useNavigate} from "react-router-dom";

const SectionLink = ({isRead, chapterId, section, i, sectionId}) => {

    const navigate = useNavigate();

    return (
        <button
            className={`btn ${section.id === sectionId ? 'btn-success' : ''} text-start d-flex justify-content-between align-items-center`}
            onClick={() => navigate(`/chapter/${chapterId}/section/${section.id}`)}
        >
            <div>{i+1}.  {section?.heading}</div>
            {isRead(section.id) &&
                <div>
                    ✅
                </div>
            }
        </button>
    )
};export default SectionLink