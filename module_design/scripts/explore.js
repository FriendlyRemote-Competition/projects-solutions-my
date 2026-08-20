const markers = document.querySelectorAll('.marker')
const exploreCards = document.querySelectorAll('.explore-card')

markers.forEach(marker => {
    marker.addEventListener('mouseover', (e) => {
        let exploreId = e.currentTarget.id

        document.querySelector(`[data-explore=${exploreId}]`).classList.add('active')
    })
    marker.addEventListener('mouseleave', (e) => {
        let exploreId = e.currentTarget.id

        document.querySelector(`[data-explore=${exploreId}]`).classList.remove('active')
    })
})

exploreCards.forEach(exploreCard => {
    exploreCard.addEventListener('mouseover', (e) => {
        let exploreId = e.currentTarget.getAttribute('data-explore')
        document.getElementById(exploreId).classList.add('active')
    })
    exploreCard.addEventListener('mouseleave', (e) => {
        let exploreId = e.currentTarget.getAttribute('data-explore')
        document.getElementById(exploreId).classList.remove('active')
    })
})