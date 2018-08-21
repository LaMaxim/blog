;(function (Vue, Moment, Axios, G) {
    console.log(G.currentUser);
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
                this.editCommentFromServer(commentId, commentValue);
            },

            clickDeleteComment: function (commentId) {
                this.deleteCommentFromServer(commentId)
            },

            sendCommentToServer: function () {
                const self = this;
                Axios.post('/post/create-comment', {
                    comment: this.value,
                    userId: this.currentUser.id,
                    postId: this.currentPostId
                }).then(function(response) {
                    response.data['user'] = self.currentUser;
                    self.comments.push(response.data);
                    self.cleanFormValue();
                }).catch(function(error) {
                    console.log('Error send comment to server', error);
                })
            },

            deleteCommentFromServer: function (commentId) {
                const self = this;
                Axios.delete('/post/delete-comment/' + commentId).then(function(response) {
                    const cleanCommentList = self.comments.filter(function(comment) {
                       return commentId !== comment.id
                    });
                    self.comments = cleanCommentList;
                }).catch(function(error) {
                    console.log('Error delete comment from server', error);
                })
            },

            editCommentFromServer: function (commentId, commentValue) {

            },

            cleanFormValue: function() {
                this.value = '';
            }
        }
    })
})(Vue, moment, axios, window._globals || {});