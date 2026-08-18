const tabs = document.querySelectorAll('.tabs button');
const title = document.querySelector('.title');
const content = document.querySelector('.content');

const contents = {
    "about":{
        title:"Introduction to WorldSkills",
        content:"WorldSkills is a global platform for young professionals to demonstrate their skills in various trades and technologies. It aims to raise the profile and confidence of skilled people and show how important skills are in achieving economic growth."
    },
    "history":{
        title:"History of WorldSkills",
        content:"WorldSkills was founded in 1950 and has since grown to include participants from over 80 countries. The competition showcases a wide range of skills, from traditional trades to multi-skilled technology jobs."
    },
    "objectives":{
        title:"Objectives of the Competition",
        content:"The competition aims to inspire young people to develop a passion for skills and pursue excellence through competition, events, and initiatives. It promotes international cooperation and exchange of knowledge."
    },
    "impact":{
        title:"Impact and Legacy",
        content:"WorldSkills leaves a lasting impact on participants by enhancing their skills, boosting their career prospects, and fostering a global network of skilled professionals. It also influences education and training standards worldwide."
    }
}

tabs.forEach(tab => {
    tab.addEventListener('click', () => {
        tabs.forEach(t => t.classList.remove('active'))
        tab.classList.add('active');

        title.innerText = contents[tab.getAttribute('data-tab')].title
        content.innerText = contents[tab.getAttribute('data-tab')].content
    })
})