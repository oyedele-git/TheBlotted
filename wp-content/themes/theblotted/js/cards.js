function createTopicCard({ img, topic, title, author, imageMaxWidth }) {
    const template = document.getElementById("topic-card-template");
    const card = template.content.cloneNode(true);

    const imageBox = card.querySelector(".card-image");
    const imageTag = card.querySelector(".card-image img");
    const topicText = card.querySelector(".card-topic");
    const titleText = card.querySelector(".card-title");
    const authorText = card.querySelector(".card-author");
    const cardWrapper = card.querySelector(".topic-cards");

    // Set image
    imageTag.src = img;

    // Override image width if needed
    if (imageMaxWidth) {
        imageBox.style.maxWidth = imageMaxWidth;
    }

    // Fill text
    topicText.textContent = topic || "";
    titleText.textContent = title || "";
    authorText.textContent = author || "";

    // If ONLY image is provided → remove gap
    if (!topic && !title && !author) {
        cardWrapper.classList.add("no-gap");
    }

    document.getElementById("topic-container").appendChild(card);
}



// Example Usage — generate 3 cards
createTopicCard({
    img: "image/image22.png",
    topic: "Issues",
    title: "How Social Media Shapes Modern Issues",
    author: "Oyedele Alokan"
});

createTopicCard({
    img: "image/image3.png",
    topic: "Pop Of Culture",
    title: "Fashion Trends Changing The World",
    author: "Casmir Cassy"
});

createTopicCard({
    img: "image/image4.jpg",
    imageMaxWidth: "100% "
});

