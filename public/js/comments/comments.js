;(function (Vue, Moment, Axios, G) {
    let app = new Vue({
        el: '#comments-container',
        data: {
            currentPostId: G.currentPostId,
            currentUser: G.currentUser,
            isEdit: false,
            EDITOR_ROLE: 'admin',
            userRole: 'user',
            value: '',
            comments: G.comments
        },
        methods: {
            getCreatedAtCommentText: function(time) {
                return moment(time).format('MM/DD/YYYY');
            },

            clickSendComment: function () {
                this.sendCommentToServer()
            },

            clickEditComment: function (commentId) {
                this.enableEditMode(commentId);
            },

            clickCloseEditComment: function(commentId) {
                this.disableEditMode(commentId);
            },

            clickDeleteComment: function (commentId) {
                this.deleteCommentFromServer(commentId)
            },

            clickSendEditComment: function(commentId) {
                const editTextareaCommentElement = document.getElementById('edit-textarea-comment-' + commentId);
                const text = editTextareaCommentElement.value;
                this.sendEditCommentToServer(commentId, text);
            },

            sendCommentToServer: function () {
                const successResp = function(response) {
                    response.data['user'] = this.currentUser;
                    this.comments.push(response.data);
                    this.cleanFormValue();
                }.bind(this);
                const errorResp = function(error) {
                    console.log('Error send comment to server', error);
                };

                Axios.post('/post/create-comment', {
                    comment: this.value,
                    userId: this.currentUser.id,
                    postId: this.currentPostId
                })
                    .then(successResp)
                    .catch(errorResp);
            },

            deleteCommentFromServer: function (commentId) {
                const successResp = function(response) {
                    const cleanCommentList = this.comments.filter(function(comment) {
                        return commentId !== comment.id
                    });
                    this.comments = cleanCommentList;
                }.bind(this);
                const errorResp = function(error) {
                    console.log('Error delete comment from server', error);
                };

                Axios.delete('/post/delete-comment/' + commentId)
                    .then(successResp)
                    .catch(errorResp)
            },

            sendEditCommentToServer: function (commentId, text) {
                const successResp = function(response) {
                    const cleanCommentList = this.comments.map(function(comment) {
                        if (comment.id === commentId) {
                            comment.text = text;
                        }
                        return comment;
                    });
                    this.comments = cleanCommentList;
                }.bind(this);
                const errorResp = function(error) {
                    console.log('Error send edited comment to server', error);
                };

                Axios.post('/post/edit-comment', {
                    id: commentId,
                    text: text
                })
                    .then(successResp)
                    this.disableEditMode(commentId)
                    .catch(errorResp);
            },

            enableEditMode(commentId) {
                const elementFormContainerId = 'edit-form-' + commentId;
                const elementTextCommentId = 'text-comment-' + commentId;
                const elementOptionPanelBtnCommentId = 'option-btn-container-' + commentId;
                document.getElementById(elementTextCommentId).style.display = 'none';
                document.getElementById(elementFormContainerId).style.display = 'block';
                document.getElementById(elementOptionPanelBtnCommentId).style.display = 'none';
            },

    disableEditMode(commentId) {
        const elementFormContainerId = 'edit-form-' + commentId;
        const elementTextCommentId = 'text-comment-' + commentId;
        const elementOptionPanelBtnCommentId = 'option-btn-container-' + commentId;
        document.getElementById(elementTextCommentId).style.display = 'block';
        document.getElementById(elementFormContainerId).style.display = 'none';
        document.getElementById(elementOptionPanelBtnCommentId).style.display = 'block';
    },

    cleanFormValue: function() {
        this.value = '';
    }
}
})
})(Vue, moment, axios, window._globals || {});