const title = document.getElementById("title");
const topic = document.getElementById("topic");
const totalVotes = document.getElementById("totalVotes");

const proResult = document.getElementById("proResult");
const conResult = document.getElementById("conResult");
const absResult = document.getElementById("absResult");

const proContainer = document.getElementById("proContainer");
const conContainer = document.getElementById("conContainer");
const absContainer = document.getElementById("absContainer");

const fetchData = async () => {
    try {
        const res = await fetch("./data.json");
        const data = await res.json();

        title.innerText = data.title;
        topic.innerText = data.topic;

        const total = data.votes.length;
        totalVotes.innerText = total;

        if (total === 0) return;

        const proAmount = data.votes.filter(v => v.vote === "pro").length;
        const conAmount = data.votes.filter(v => v.vote === "con").length;
        const absAmount = data.votes.filter(v => v.vote === "abs").length;

        proResult.innerText = `${Math.round((proAmount / total) * 100)}% (${proAmount} votes)`;
        conResult.innerText = `${Math.round((conAmount / total) * 100)}% (${conAmount} votes)`;
        absResult.innerText = `${Math.round((absAmount / total) * 100)}% (${absAmount} votes)`;

        const maxVotes = Math.max(proAmount, conAmount, absAmount);

        const highlightWinner = (element) => {
            element.style.color = "green";
            element.style.fontWeight = "bold";
            element.classList.add("border-success");
        };

        if (proAmount === maxVotes && proAmount > 0) {
            highlightWinner(proContainer);
        }
        if (conAmount === maxVotes && conAmount > 0) {
            highlightWinner(conContainer);
        }
        if (absAmount === maxVotes && absAmount > 0) {
            highlightWinner(absContainer);
        }

    } catch (err) {
        console.error(err);
    }
};

fetchData();