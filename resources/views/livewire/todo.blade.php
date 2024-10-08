{{-- <div>
    <div class="h-100 w-full flex items-center justify-center bg-teal-lightest font-sans">
        <div class="bg-white rounded shadow p-6 m-4 w-full lg:w-3/4 lg:max-w-lg">
            <div class="mb-4">
                <h1 class="text-grey-darkest">Todo List</h1>
                <form class="flex mt-4" wire:submit="addTodo">
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 mr-4 text-grey-darker"
                        wire:model="todoText"
                        name="todoText"
                        placeholder="Add Todo">
                    <button
                        class="flex-no-shrink p-2 border-2 rounded text-teal border-teal hover:text-black hover:bg-teal">
                        Add
                    </button>
                </form>
            </div>
            <div>
                @foreach ($todos as $todo)
                    <div class="flex mb-4 items-center">
                        <p class="w-full text-grey-darkest">{{ $todo->todo }}</p>
                        <button wire:click="updateTodoMarkDone({{ $todo->id }}, true)" class="flex-no-shrink p-2 ml-4 mr-2 border-2 rounded hover:text-black text-green border-green hover:bg-green">
                            Done
                        </button>
                        <button wire:click="deleteTodo({{ $todo->id }})" class="flex-no-shrink p-2 ml-2 border-2 rounded text-red border-red hover:text-black hover:bg-red">
                            Remove
                        </button>
                    </div>
                @endforeach
            </div>

        </div>
    </div>

</div> --}}

<div>

    <style>
        @import url("https://fonts.googleapis.com/css?family=Nunito:600,700&display=swap");

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
        }

        body {
            min-height: 450px;
            height: 100vh;
            margin: 0;
            background: radial-gradient(ellipse farthest-corner at center top, #f39264 0%, #f2606f 100%);
            color: #fff;
            font-family: "Nunito", sans-serif;
        }

        button,
        input,
        select,
        textarea {
            font-family: inherit;
            font-size: inherit;
            line-height: inherit;
        }

        /*-------------------- ToDo List -------------------*/
        .todoList {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 320px;
            height: 500px;
            background: #fff;
        }

        /** Header Image **/
        .cover-img .cover-inner {
            background: url("://images.unsplash.com/photo-1516483638261-f4dbaf036963?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1533&q=80");
            height: 190px;
            background-size: cover;
            background-position: 10% 20%;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            position: relative;
        }

        .cover-img .cover-inner::after {
            background: rgba(0, 0, 0, 0.3);
            content: "";
            top: 0;
            left: 0;
            position: absolute;
            width: 100%;
            height: 100%;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .cover-img .cover-inner h3 {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-family: "Nunito", sans-serif;
            text-transform: uppercase;
            font-size: 2.8rem;
            z-index: 10;
            font-weight: 700;
        }

        /* Main Content */
        .content {
            padding: 10px 20px;
        }

        .content form {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            padding: 0 10px 0 5px;
            border-bottom: 1px solid #8e979c;
        }

        .content form>* {
            background: transparent;
            border: none;
            height: 35px;
        }

        .content input[type=text] {
            font-weight: 700;
            font-size: 1.2rem;
            color: #6C717B;
        }

        .content .input-buttons a {
            text-decoration: none;
        }

        .content .input-buttons i {
            margin-top: 5px;
            font-size: 20px;
            color: #8e979c;
        }

        .content ul.todos {
            margin-left: 0;
            padding: 0;
            list-style: none;
            height: 220px;
            overflow: auto;
        }

        .content li {
            user-select: none;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
        }

        .content li i {
            color: #6C717B;
            font-size: 15px;
            cursor: pointer;
            padding: 5px 10px;
        }

        .content input[type=checkbox] {
            display: none;
        }

        .content input[type=checkbox]+label {
            color: #6C717B;
            font-size: 15px;
            cursor: pointer;
            position: relative;
            border-radius: 3px;
            display: inline-block;
            padding: 5px 5px 5px 30px;
        }

        .content input[type=checkbox]+label:hover {
            color: #353A42;
            background-color: #F4F7FA;
        }

        .content input[type=checkbox]+label span.check {
            left: 4px;
            top: 50%;
            position: absolute;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            display: block;
            background: white;
            border-radius: 3px;
            border: 1px solid #b8bfcc;
            box-shadow: 0 2px 3px #F0F4F8;
        }

        .content input[type=checkbox]:checked+label {
            color: #AEB7C6;
            text-decoration: line-through;
        }

        .content input[type=checkbox]:checked+label span.check {
            background-color: transparent;
            border-color: transparent;
            box-shadow: none;
        }

        .content input[type=checkbox]+label span.check::after {
            width: 100%;
            height: 100%;
            content: "";
            display: block;
            position: absolute;
            background-image: url("https://tjgillweb.github.io/Vacation-Todo-App/images/tick.svg");
            background-repeat: no-repeat;
            background-position: center;
            background-size: 16px 16px;
            transform: scale(0);
            transition: transform 300ms cubic-bezier(0.3, 0, 0, 1.5);
        }

        .content input[type=checkbox]:checked+label span.check::after {
            transform: scale(1);
        }

        .content input[type=checkbox]+label span.check::before {
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: block;
            content: "";
            position: absolute;
            border-radius: 50%;
            background: #8798AA;
            opacity: 0.8;
            transform: scale(0);
        }

        .content input[type=checkbox]:checked+label span.check::before {
            opacity: 0;
            transform: scale(1.3);
            transition: opacity 300ms cubic-bezier(0.2, 0, 0, 1), transform 400ms cubic-bezier(0.3, 0, 0, 1.4);
        }

        /** Social Icons **/
        @media (max-width: 767px) {
            .social {
                display: none;
            }
        }

        @media (min-width: 767px) {
            .social {
                position: absolute;
                right: 0;
                top: 33.33%;
            }

            .social ul {
                display: flex;
                flex-direction: column;
                list-style: none;
                padding: 0;
                margin: 0;
            }

            .social ul li {
                margin: 5px 10px;
            }

            .social ul li a {
                color: #403f4c;
                font-size: 25px;
                height: 50px;
                width: 50px;
                text-decoration: none;
            }

            .social ul li a:hover {
                color: #272523;
            }
        }
    </style>
    <div class="todoList">

        <div class="cover-img">
            <div class="cover-inner">
                <h3>To do
                </h3>
            </div>
        </div>
        <div class="content">
            <form class="add" wire:submit.prevent="addTodo">
                <input type="text" wire:model="todoText" name="todoText" placeholder="Add item...">

            </form>
            <ul class="todos">
                @foreach ($todos as $todo)
                    <li>
                        <input type="checkbox"
                            wire:change="updateTodoMarkDone({{ $todo->id }}, $event.target.checked)"
                            id="todo_{{ $todo->id }}" {{ $todo->isFinish == 1 ? 'checked' : '' }} />
                        <label for="todo_{{ $todo->id }}">
                            <span class="check"></span>{{ $todo->todo }}
                        </label>
                        <button wire:click="deleteTodo({{ $todo->id }})" class="flex-no-shrink p-2 ml-2 border-2 rounded text-red border-red text-black">
                            Delete
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
