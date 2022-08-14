<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <link rel="stylesheet" href="css/main.css">
    <title>Counter</title>
</head>
<body>
<nav class="navbar navbar-light bg-light">
    <div class="container px-4  ">
        <div class="row gx-5">
            <div class="col">
                <div class="p-3  border bg-light">Negative Posts</div>
            </div>
            <div class="col">
                <div class="p-3  border bg-light Post-Count">All Posts</div>
            </div>
            <div class="col">
                <div class="p-3  border bg-light ">Positive Posts</div>
            </div>
        </div>
    </div>
</nav>
<h2 class="text-center mt-3 col-md-12">POSTS</h2>
<div class="AddPost d-flex justify-content-end p-5">
    <button onclick="PopUp()" class=" bg-primary">Add Post</button>
</div>

<div class="b-popup" id="formAddPost">
    <form action="" class="b-container mt-5 " id="formAddPostt">
        <div>
            <label for="name" class="m-3">Name</label>
            <input type="text" id="name" placeholder="name">
        </div>
        <div>
            <label for="text" class="m-3">Text</label>
            <textarea name="context" id="context" cols="50" rows="3"></textarea>
        </div>
        <div class="alert alert-danger mt-2" id="errorBlock"></div>
        <div class="d-flex justify-content-end">
            <a class="b-popup-content btn btn-primary" id='AddPost'>Published</a>
        </div>
    </form>
</div>
<div id="min" class=" container justify-content-center ">

</div>

</body>
<script>
    $(document).ready(function () {
        show();
        PopUpHide();
        $('#errorBlock').hide()
    });

    function PopUp() {
        $('#formAddPost').show()
    }

    function PopUpComm() {
        const changeNameButton = document.querySelector('#AddPost')
        document.getElementById("formAddPostt").reset();
        changeNameButton.innerHTML = 'AddComment'
        $('#formAddPost').show()
        adCom()
    }

    function adCom() {
        const name = $('#name').val()
        const context = $('#context').val()
        if (name == '' && context == '') {
            return;
        } else {
            $.ajax({
                url: 'ajax/AddComment.php',
                type: 'POST',
                cache: false,
                data: {
                    'name': name,
                    'context': context,
                },
                dataType: 'html',
                success: function (data) {
                    if (data == true) {
                        $('#errorBlock').hide()

                        $("#formAddPost").hide()
                    } else {
                        $('#errorBlock').show()
                        $('#errorBlock').text(data)
                    }
                }
            })
        }
    }


    $('#AddPost').click(function () {
        const changeNameButton = document.querySelector('#AddPost')
        if (changeNameButton.textContent !== 'AddPost') {
            return
        } else {
            const name = $('#name').val()
            const context = $('#context').val()
            $.ajax({
                url: 'ajax/AddPost.php',
                type: 'POST',
                cache: false,
                data: {
                    'name': name,
                    'context': context,
                },
                dataType: 'html',
                success: function (data) {
                    if (data == true) {
                        $('#errorBlock').hide()
                        $("#formAddPost").hide()
                        renderPost()
                    } else {
                        $('#errorBlock').show()
                        $('#errorBlock').text(data)
                    }
                }
            })
        }
    })


    function renderPost() {
        if (($('#name').val() !== '') && $('#context').val() !== '') {
            const name = $('#name').val()
            const context = $('#context').val()
            let min = document.getElementById("min");
            min.innerHTML = min.innerHTML + `<div class="card  my-4 w-50"><button  class="btn btn-success buut" id="qwe">Add Comment</button><span class="p-3">${name} </span> <p class="p-3"> ${context}</p><span class="text-end p-1"> ${new Date().toDateString()} </span><span  hidden class="id"> ${item["id"]}</span></div>`
        }
    }

    function PopUpHide() {
        $("#formAddPost").hide();
        $('#errorBlock').hide()
    }

    function show() {
        $.ajax({
            url: "ajax/GetAllPostsController.php",
            cache: false,
            success: function (data) {
                data = JSON.parse(data)
                console.log(data.length)
                data.forEach(item => {
                    console.log(item['id']) // нужные свойства
                    let author = document.createElement('span')
                    let btn = document.createElement('button')
                    author.className = 'sp'
                    btn.className = 'but'
                    btn.innerHTML = 'Add Comment'
                    author.innerHTML = `<div class='card  my-4 w-50 '><button onclick="PopUpComm()" class="btn btn-success buut" id="qwe">Add Comment</button><span class='p-3'> ${item['author']}</span> <p class='p-3'> ${item['context']}</p> <span class='text-end p-1'> ${new Date(item['date'] * 1000).getDate()}.${new Date(item['date'] * 1000).getMonth()}.${new Date(item['date'] * 1000).getFullYear()}</span><span  hidden class="id">${item['id']}</span><div class="rating rating_set"><div class="rating_body"><div class="rating_active"></div><div class="rating_items"><input type="radio" class="rating_item" value="1" name="rating"><input type="radio" class="rating_item" value="2" name="rating"><input type="radio" class="rating_item" value="3" name="rating"><input type="radio" class="rating_item" value="4" name="rating"><input type="radio" class="rating_item" value="5" name="rating"></div></div><div class="rating_value">3.6</div></div></div>`
                    document.querySelector('#min').appendChild(author)
                })
                let countPost = document.querySelector('.Post-Count')
                countPost.innerHTML = countPost.textContent + ': ' + data.length
                const ratings = document.querySelectorAll('.rating')
                if (ratings.length > 0) {
                    initRatings()
                }

                function initRatings() {
                    let ratingActive, ratingValue;
                    for (let index = 0; index < ratings.length; index++) {
                        const rating = ratings[index];
                        initRating(rating)
                    }

                    function initRating(rating) {
                        initRatingVars(rating)
                        setRatingActiveWidth()
                        if (rating.classList.contains('rating_set')) {
                            setRating(rating)
                        }
                    }

                    function initRatingVars(rating) {
                        ratingActive = rating.querySelector('.rating_active')
                        ratingValue = rating.querySelector('.rating_value')
                    }

                    function setRatingActiveWidth(index = ratingValue.innerHTML) {
                        const ratingActiveWidth = index / 0.05;
                        ratingActive.style.width = `${ratingActiveWidth}%`;
                    }

                    function setRating(rating) {
                        const ratingItems = rating.querySelectorAll('.rating_item')
                        for (let index = 0; index < ratingItems.length; index++) {
                            const ratingItem = ratingItems[index];
                            ratingItem.addEventListener("mouseenter", function (e) {
                                initRatingVars(rating)
                                setRatingActiveWidth(ratingItem.value)
                            });
                            ratingItem.addEventListener("mouseleave", function (e) {
                                setRatingActiveWidth()
                            });
                            ratingItem.addEventListener("click", function (e) {
                                initRatingVars(rating)
                                if (rating.dataset.ajax) {
                                    setRatingValue(ratingItem.value, rating)
                                } else {
                                    ratingValue.innerHTML = index + 1;
                                    setRatingActiveWidth();
                                }
                            });
                        }
                    }
                }

            }
        });
    }
</script>
</html>