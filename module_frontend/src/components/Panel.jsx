import {useStore} from "../store.jsx";

const Panel = () => {

    const {panelOpen, setPanelOpen, settings, setSettings} = useStore()

    const handleRangeChange = (value) => {
        setSettings(prev => ({ ...prev, spacing: value }))
    }

    const handleSizeChange = (value) => {
        console.log(value)
        setSettings(prev => ({ ...prev, size: value }))
    }

    return (panelOpen &&
        <div className={'vw-100 vh-100 fixed-top'} style={{backgroundColor:"rgba(0,0,0,0.4)"}}>
            <div
                className={'card rounded-0 position-absolute end-0 vh-100'}
                style={{width:"300px"}}
            >
                <div className="card-body d-flex flex-column gap-3">
                    <div className="d-flex gap-2 align-items-center justify-content-between">
                        <div className={'fw-bold'}>Reading Settings</div>
                        <button onClick={() => setPanelOpen(false)} className={'btn btn-close'}></button>
                    </div>
                    <div>
                        <small className={'text-secondary fw-bold'}>FONT SIZE</small>
                        <div className={'d-flex gap-2'}>
                            <button onClick={() => handleSizeChange("12px")} className={`flex-grow-1 text-center btn ${settings.size === "12px" ? "btn-primary" : "btn-outline-primary"}`}>A -</button>
                            <button onClick={() => handleSizeChange("16px")} className={`flex-grow-1 text-center btn ${settings.size === "16px" ? "btn-primary" : "btn-outline-primary"}`}>A</button>
                            <button onClick={() => handleSizeChange("20px")} className={`flex-grow-1 text-center btn ${settings.size === "20px" ? "btn-primary" : "btn-outline-primary"}`}>A +</button>
                        </div>
                    </div>
                    <div>
                        <small className={'text-secondary fw-bold'}>COLOUR THEME</small>
                        <div className={'d-flex gap-2'}>
                            <div className={'flex-grow-1 text-center btn border border-secondary text-secondary'}>LIGHT</div>
                            <div className={'flex-grow-1 text-center btn border border-secondary text-secondary'}>DARK</div>
                        </div>
                    </div>
                    <div className={'d-flex gap-2 flex-column'}>
                        <small className={'text-secondary fw-bold'}>LINE SPACING</small>
                        <input onChange={e => handleRangeChange(e.target.value)} className={'form-range'} type="range" min={0.5} value={settings.spacing} step={0.1} max={3}/>
                    </div>
                </div>
            </div>
        </div>
    )
};export default Panel