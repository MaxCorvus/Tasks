let alreadyRated = []
function rerenderPage() {

    $('.post-section').empty()
    $.get('http://localhost/Blog/posts', function (data) {
        const posts = JSON.parse(data)
        const allPosts = posts.length
        const positivePosts = posts.filter((post) => post.rate >= 4).length
        const negativePosts = posts.filter((post) => post.rate <= 2 && post.rate > 0).length
        $('#all').text(allPosts)
        $('#negative').text(negativePosts)
        $('#positive').text(positivePosts)

        posts.forEach((post) => {
            let filledStars = ''
            let emptyStars = 5 - Math.round(post.rate)

            for (let i = 0; i < Math.round(post.rate); i++) {
                filledStars += `<img  class="star ${!alreadyRated.includes(post.id) ? "rate" : ""}" data-post-id="${post.id}" data-value="${i + 1}" src="FrontEnd/img/star.png">`
            }

            for (let i = 0; i < emptyStars; i++) {
                filledStars += `<img class="star ${!alreadyRated.includes(post.id) ? "rate" : ""}" data-post-id=${post.id} data-value=${parseInt(post.rate) + i + 1} src="FrontEnd/img/star_empty.png">`
            }
            let commentsBlock=''
            post.comments.forEach((comment) => {
                commentsBlock += `<div class="comment-body bg-white p-2 border border-dark">
                    <div class="d-flex flex-row user-info">
                        <div class="d-flex flex-column justify-content-start ml-2"><span
                            class="d-block font-weight-bold name"><i>by ${comment.name}</i></span><span
                            class="date text-black-50">${comment.created_at}</span></div>
                    </div>
                    <div class="mt-2">
                        <p class="post-text">${comment.text}</p>
                    </div>
                  
                </div>`
            })
            $('.post-section').append(`<div class="post-body bg-white p-2 border border-dark">
                    <div class="d-flex flex-row user-info">
                        <div class="d-flex flex-column justify-content-start ml-2"><span
                            class="d-block font-weight-bold name"><i>by ${post.name}</i></span><span
                            class="date text-black-50">${post.created_at}</span></div>
                    </div>
                    <div class="mt-2">
                        <p class="post-text">${post.text}</p>
                    </div>
                    <div class="starBlock">
                        ${filledStars}
                </div>
                     <div class="block_btn">
                      <button type="button" name="btn_ok" class="btn-add-comment btn btn-primary default" data-toggle="modal"
                            data-target="#post-modal" id="addComment" data-post-id="${post.id}">Add Comment</button>
                    </div>
                </div>
                <div class="commentsBlock">
                        ${commentsBlock} 
                </div>
                   `)
        })
        addHandlers()
    })

}
$(document).ready(() => {

    rerenderPage()
    $('#addPost').click(function () {
        $('#post_id').val('')
        $('#UserModalLabel').text("Add Post")
        $('#name').val('')
        $('#text').val('')
    })
    $('#FormForPost').submit(function (event) {
        event.preventDefault();
        return false

    });
    $('#postSave').click(function (){
        const name = $('#name').val()
        const text = $('#text').val()
        const postId = $('#post_id').val()
        if ($.trim(name)!='' && $.trim(text) != '') {
            if (postId) {
                $.post('http://localhost/Blog/addComment', {
                    'post_id' : postId,
                    'name': name,
                    'text': text
                }, function (data) {
                    rerenderPage()
                    $('.modal').css('display', 'none')
                    $('.modal-backdrop').remove()
                })

            }
            else {
                $.post('http://localhost/Blog/addPost', {
                    'name': name,
                    'text': text
                }, function (data) {
                    rerenderPage()
                    $('.modal').css('display', 'none')
                    $('.modal-backdrop').remove()
                })

            }
        }
    })


})
function addHandlers() {
    $('.rate').click(function () {
        const data = $(this).data();
        alreadyRated.push(data.postId)
        $.post('http://localhost/Blog/addRate', {
            value: data.value,
            post_id: data.postId
        }, () => {
            rerenderPage()
        })
    })
    $('.btn-add-comment').click(function (){
        $('#UserModalLabel').text("Add Comment")
        $('#name').val('')
        $('#text').val('')
        const data = $(this).data();
        $('#post_id').val(data.postId)
    })
}