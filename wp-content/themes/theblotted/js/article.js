// LIKE & DISLIKE
document.querySelectorAll(".actions").forEach((group, index) => {
    const like = group.querySelector(".like");
    const dislike = group.querySelector(".dislike");

    like.dataset.id = "like-" + index;
    dislike.dataset.id = "dislike-" + index;

    let likeCount = parseInt(like.textContent.replace(/\D/g, ""));
    let dislikeCount = parseInt(dislike.textContent.replace(/\D/g, ""));

    like.addEventListener("click", () => {
        const isActive = like.classList.contains("active");

        if (isActive) {
            likeCount--;
            like.classList.remove("active");
            like.querySelector("img").src = "image/like inactive.png";
        } else {
            likeCount++;
            like.classList.add("active");
            like.querySelector("img").src = "image/like active.png";

            if (dislike.classList.contains("active")) {
                dislikeCount--;
                dislike.classList.remove("active");
                dislike.querySelector("img").src = "image/dislike inactive.png";
            }
        }

        like.innerHTML = `<img src="${isActive ? 'image/like inactive.png' : 'image/like active.png'}"> ${likeCount}`;
        dislike.innerHTML = `<img src="image/${dislike.classList.contains('active') ? 'dislike active.png' : 'dislike inactive.png'}"> ${dislikeCount}`;
    });

    dislike.addEventListener("click", () => {
        const isActive = dislike.classList.contains("active");

        if (isActive) {
            dislikeCount--;
            dislike.classList.remove("active");
            dislike.querySelector("img").src = "image/dislike inactive.png";
        } else {
            dislikeCount++;
            dislike.classList.add("active");
            dislike.querySelector("img").src = "image/dislike active.png";

            if (like.classList.contains("active")) {
                likeCount--;
                like.classList.remove("active");
                like.querySelector("img").src = "image/like inactive.png";
            }
        }

        dislike.innerHTML = `<img src="${isActive ? 'image/dislike inactive.png' : 'image/dislike active.png'}"> ${dislikeCount}`;
        like.innerHTML = `<img src="image/${like.classList.contains('active') ? 'like active.png' : 'like inactive.png'}"> ${likeCount}`;
    });
});


// SHOW REPLY INPUT BOX
document.querySelectorAll(".reply-comment").forEach((btn, index) => {
    btn.dataset.id = "reply-" + index;

    btn.addEventListener("click", () => {
        if (btn.parentElement.querySelector(".reply-input-box")) return;

        const box = document.createElement("div");
        box.className = "reply-input-box";

        box.innerHTML = `
            <textarea placeholder="Write a reply..."></textarea>
            <button class="close-reply">×</button>
        `;

        btn.parentElement.appendChild(box);

        box.querySelector(".close-reply").addEventListener("click", () => {
            box.remove();
        });
    });
});


// TOGGLE SHOW/HIDE REPLIES
document.querySelectorAll(".toggle-replies").forEach((btn) => {
    btn.addEventListener("click", () => {
        const replies = btn.parentElement.querySelectorAll(
            ".content-contributor1, .content-contributor2"
        );

        const isHidden = replies[0].style.display === "none";

        replies.forEach((r) => {
            r.style.display = isHidden ? "flex" : "none";
        });

        btn.textContent = isHidden
            ? "Hide replies (123) ^"
            : "Show replies (123) v";
    });
});
