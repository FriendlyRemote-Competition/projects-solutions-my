const fetchStory = async () => {
    try{
        const res = await fetch('./content/hotel-copy.json')
        const data = await res.json()
        console.log(data)

        let storyHTML = `
            <div class="desc">
                <small>${data.eyebrow.toUpperCase()}</small>
                <h1>${data.heading}</h1>
                <div class="para">
                    ${data.body}
                </div>
                <hr>
                <div class="stats">
                    <div>
                        <div class="num">${data.stats[0].value}</div>
                        <small>${data.stats[0].label.toUpperCase()}</small>
                    </div>
                    <div>
                        <div class="num">${data.stats[1].value}</div>
                        <small>${data.stats[1].label.toUpperCase()}</small>
                    </div>
                    <div>
                        <div class="num">${data.stats[2].value}${data.stats[2].suffix}</div>
                        <small>${data.stats[2].label.toUpperCase()}</small>
                    </div>
                </div>
            </div>
        `
        document.querySelector('.story main').innerHTML += storyHTML

    }catch(error){
        console.error(error);
    }
}
fetchStory();