<!DOCTYPE html>
<html lang="fa-IR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>آزمون آنلاین فرانت کد</title>
    <style>
        body {
            text-align: center;
            overflow-x: hidden;
            height: 100vh;
            /* background-size: 400% 400%; */
            background-image: url('./html.webp');
            background-size: cover;
            background-position: -400px 80px;
            animation: gradiant-animate 15s infinite;
            color: #fff;
            border: 6px solid #ff4500;
            animation: 1s border_opacity infinite;
        }

        @keyframes border_opacity {
            0% {
                border-color: #ff4500;
            }

            100% {
                border-color: rgba(255, 69, 0, 0.5);
            }

            0% {
                border-color: #ff4500;
            }
        }

        .front-code-link {
            text-decoration: none;
            color: #ff4500;
            font-weight: bold;
        }

        #introduce {
            color: white;
            text-decoration: none;
            font-weight: bold;
            display: block;
            /* width: 100%; */
            padding: 10px 10px;
            background-color: #ff4500;
            text-align: center;
            font-size: 25px;
            margin-bottom: 45px;
        }


        .front-code {
            cursor: pointer;
            border: 0;
            border-radius: 10px;
            padding: 7px 10px;
            background: #fff;
        }

        .front-code:hover {
            background: rgba(72, 255, 0, 0.1);
        }

        .container {
            width: 100%;
            text-align: center;
        }

        .container table {
            display: inline-block;
            margin-bottom: 20px;
        }

        .container table td {
            text-align: right;
            font-size: 20px;
        }

        #submit {
            font-weight: bold;
            border: none;
            outline: none;
            padding: 5px 35px;
            background: #ff4500;
            color: #fff;
            font-size: large;
            border-radius: 10px;
            cursor: pointer;
        }

        #submit:hover {
            background-color: rgba(255, 69, 0, 0.4);
            opacity: 0.7;
        }

        .quiz-ans-list {
            transform: scale(1.3);
        }

        .modal-user {
            position: absolute;
            width: 50%;
            left: 25%;
            background-color: #ccc;
            color: white;
            border: 3px solid black;
            border-radius: 4px;
            padding: 80px 0;
            top: -400px;
            transition: 0.3s all;
            z-index: 5;
        }

        .modal-user.active {
            top: 0;
        }

        .modal-user h1 {
            font-size: 45px;
        }

        .modal-user#correct {
            background-color: #4CAF50
        }

        .modal-user#wrong {
            background-color: red;
        }

        #user-overview {
            font-size: 25px;
        }
    </style>
</head>

<body>
    <a id="introduce" target="_blank" href="https://front-code.ir">html آزمون تستی</a>
    <button class="front-code"><a href="https://front-code.ir" target="_blank" class="front-code-link">وبسایت فرانت
            کد</a></button>
    <div class="container">

        <section class="modal-user" id="">
            <h1></h1>
        </section>

        <div id="user-overview">
            <button>مشاهده تمامی جواب ها</button>
        </div>

        <form method="POST" id="form-quiz">
            <p class="score"><span>امتیاز : </span><span id="value">0</span></p>
            <p class="quiz-of"><span>سوال </span><span id="part">x</span><span> از </span><span id="all">x</span></p>

            <div class="question">
                <h3>x</h3>
            </div>

            <table>
                <tbody>
                    <tr>
                        <td></td>
                        <td><input id="q1" class="quiz-ans-list" type="radio" name="answer-quiz" value="x"></td>
                    </tr>

                    <tr>
                        <td>x</td>
                        <td><input id="q2" class="quiz-ans-list" type="radio" name="answer-quiz" value="x"></td>
                    </tr>

                    <tr>
                        <td>x</td>
                        <td><input id="q3" class="quiz-ans-list" type="radio" name="answer-quiz" value="x"></td>
                    </tr>

                    <tr>
                        <td>x</td>
                        <td><input id="q4" class="quiz-ans-list" type="radio" name="answer-quiz" value="x"></td>
                    </tr>
                </tbody>
            </table>

            <br>
            <input type="button" id="submit" name="submit" value="ثبت">
            <input type="hidden" id="qid" value="x">
        </form>


    </div>


    <script>
        (function() {

            const submitDOM = document.getElementById("submit");
            const userScoreDOM = document.querySelector(".score #value");
            const userModalDOM = document.querySelector(".modal-user");
            const formQuizDOM = document.getElementById("form-quiz");
            const userModalHeadDOM = userModalDOM.children[0];
            let userScore = 0;

            userScoreDOM.textContent = userScore;
            submitDOM.addEventListener("click", submit_handler);

            function submit_handler() {
                changeDOMState(true);
                const quizAnswerList = document.getElementsByClassName("quiz-ans-list");
                const qid = document.getElementById('qid');
                let checked = false;
                for (var element of quizAnswerList) {
                    if (element.checked) {
                        checked = true;
                        postData({
                            qid: qid.value,
                            ans: true
                        }, {
                            userAnswer: element.value
                        });
                    }
                }
                if (!checked) {
                    changeDOMState(false);
                    alert("لطفا یکی از موارد زیر را انتخاب کنید");
                }


            }

            function changeDOMState(lock = true) {

                if (lock) {
                    submitDOM.setAttribute("disabled", "disabled");
                    formQuizDOM.style.opacity = 0.2;
                } else {
                    submitDOM.removeAttribute("disabled");
                    formQuizDOM.style.opacity = 1;
                }
            }

            function resetUserModal() {
                userModalDOM.classList.remove("active");
                userModalDOM.id = "x";
            }

            function userOverviewHandler(overview) {
                resetUserModal();
                document.getElementById("form-quiz").remove();

                document.getElementById("user-overview").innerHTML = `<span>تعداد پاسخ صحیح : ${userScore}</span><br><span>تعداد پاسخ غلط : ${overview.wrongAnswer}</span><br><span>تعداد کل سوالات : ${overview.total}</span><br><a onclick="location.reload()" href="#">آزمون مجدد</a>`;
                var btn =document.createElement('button')
            }

            function quiz_answer_handler(quizObject, option) {

                const isCorrect = quizObject.key === option.userAnswer ? true : false;

                if (isCorrect) {
                    userScore++;
                    userModalDOM.id = "correct";
                    userModalHeadDOM.textContent = "درست✅";
                } else {
                    userModalDOM.id = "wrong";
                    userModalHeadDOM.textContent = "نادرست❌";
                }

                userModalDOM.classList.toggle("active");
                userScoreDOM.textContent = userScore;

                setTimeout(changeDOMState, 2500, false);

                if (parseInt(option.qid) < parseInt(quizObject.total))
                    setTimeout(postData, 2000, {
                        qid: (parseInt(option.qid) + 1)
                    });
                else {
                    const wrongAnswer = parseInt(quizObject.total) - parseInt(userScore);
                    setTimeout(userOverviewHandler, 2000, {
                        total: quizObject.total,
                        wrongAnswer: wrongAnswer
                    });
                }
            }

            function quiz_question_handler(quizObject) {
                // id , question , question-list[]  , total
                const qid = document.querySelector("#qid");
                const question = document.querySelector(".question h3");
                const questionAnswerList = document.querySelectorAll(".quiz-ans-list");

                const quizPart = document.querySelector(".quiz-of #part");
                const quizTotal = document.querySelector(".quiz-of #all");


                qid.value = quizObject.id;
                question.textContent = quizObject.question;
                quizPart.textContent = quizObject.id;
                quizTotal.textContent = quizObject.total;



                let counter = 0;
                for (const quizQ of quizObject['question-list']) {
                    const currentElement = questionAnswerList[counter];
                    currentElement.value = quizQ;
                    currentElement.checked = false;
                    currentElement.parentElement.previousElementSibling.textContent = quizQ;
                    counter++;
                }

            }

            function postData(formDataArgs, option = {}) {

                resetUserModal();

                const quizUrl = location.href + "quiz-response.php";
                const frmData = new FormData();

                for (const frmKey in formDataArgs) {
                    frmData.append(frmKey, formDataArgs[frmKey]);
                }

                const xhr = new XMLHttpRequest();
                xhr.open("post", quizUrl);
                xhr.responseType = "json";

                xhr.onreadystatechange = function() {
                    if (this.status === 200 && this.readyState === XMLHttpRequest.DONE) {
                        var responseData = this.response;
                        if (responseData.msg)
                            throw new Error("somthing went Wrong ):");


                        if (formDataArgs.ans !== undefined) {
                            option.qid = formDataArgs.qid;
                            quiz_answer_handler(responseData, option);
                        } else
                            quiz_question_handler(responseData);

                    }
                }

                xhr.send(frmData);

            }

            postData({
                qid: 1
            });

        })();
    </script>

</body>

</html>