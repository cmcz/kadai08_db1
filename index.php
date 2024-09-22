<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <title>Review Site</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="./css/reset.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./css/general.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./css/discussion.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./css/topic.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./css/upload.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    
    <!-- Pop-Up Insert Place -->
    <div id="topic-modal" class="modal hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center p-10">
        <div class="bg-white p-6 rounded-lg relative max-w-3xl w-full overflow-auto" style="max-height: calc(100vh - 200px);">
    
        <!-- Cancel Button -->
        <button id="close-modal-btn" class="absolute top-4 right-4 text-black">
            <svg width="24px" height="24px" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" stroke-width="3" stroke="#000" fill="none">
                <line x1="8.06" y1="8.06" x2="55.41" y2="55.94"></line>
                <line x1="55.94" y1="8.06" x2="8.59" y2="55.94"></line>
            </svg>
        </button>
    
        <h2 class="text-2xl font-bold text-gray-800 mb-4">New Place</h2>

        <!-- Form -->
        <form id="locationForm" action="php/write_place_upload_image.php" method="post" class="space-y-4" enctype="multipart/form-data">

            <!-- Image Upload -->
            Select images to upload:
            <input type="file" name="images[]" id="image-input" multiple accept="image/*">
            <div class="preview-container" id="preview-container"></div>

            <div id="error-container">
                <ul id="error-messages"></ul> <!-- Error messages will be displayed here -->
            </div>

            <!-- Icon Selection Area -->
            <div class="grid grid-cols-4 gap-4 mb-4">
                <label class="cursor-pointer">
                    <input type="radio" name="new-user-icon" value="./img/1.png" class="hidden" checked>
                    <img src="./img/1.png" alt="1" class="w-20 h-20 object-cover border-2 border-transparent hover:border-blue-300 rounded-full">
                </label>
                <label class="cursor-pointer">
                    <input type="radio" name="new-user-icon" value="./img/2.png" class="hidden">
                    <img src="./img/2.png" alt="2" class="w-20 h-20 object-cover border-2 border-transparent hover:border-blue-300 rounded-full">
                </label>
                <label class="cursor-pointer">
                    <input type="radio" name="new-user-icon" value="./img/3.png" class="hidden">
                    <img src="./img/3.png" alt="3" class="w-20 h-20 object-cover border-2 border-transparent hover:border-blue-300 rounded-full">
                </label>
                <label class="cursor-pointer">
                    <input type="radio" name="new-user-icon" value="./img/4.png" class="hidden">
                    <img src="./img/4.png" alt="4" class="w-20 h-20 object-cover border-2 border-transparent hover:border-blue-300 rounded-full">
                </label>

                <label class="cursor-pointer">
                    <input type="radio" name="new-user-icon" value="./img/5.png" class="hidden">
                    <img src="./img/5.png" alt="4" class="w-20 h-20 object-cover border-2 border-transparent hover:border-blue-300 rounded-full">
                </label>
                <label class="cursor-pointer">
                    <input type="radio" name="new-user-icon" value="./img/6.png" class="hidden">
                    <img src="./img/6.png" alt="6" class="w-20 h-20 object-cover border-2 border-transparent hover:border-blue-300 rounded-full">
                </label>
                <label class="cursor-pointer">
                    <input type="radio" name="new-user-icon" value="./img/7.png" class="hidden">
                    <img src="./img/7.png" alt="7" class="w-20 h-20 object-cover border-2 border-transparent hover:border-blue-300 rounded-full">
                </label>
                <label class="cursor-pointer">
                    <input type="radio" name="new-user-icon" value="./img/8.png" class="hidden">
                    <img src="./img/8.png" alt="8" class="w-20 h-20 object-cover border-2 border-transparent hover:border-blue-300 rounded-full">
                </label>
            </div>

            <!-- Info -->
            <h2 id="modal-title" class="text-3xl font-bold mb-6 text-gray-800">
                <input id="location-name" name="location-name" class="w-full text-3xl font-bold text-gray-800 border-b border-gray-300 focus:outline-none focus:border-gray-500" type="text" value="Unknown" required placeholder="Enter the name of the place">
            </h2>

            <div>
                <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                <input type="text" id="address" name="address" class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-gray-400 focus:border-transparent" required placeholder="Enter the full address">
            </div>

            <div class="flex space-x-2">
                <div class="w-1/2">
                    <label for="lat" class="block text-sm font-medium text-gray-700 mb-1">Latitude</label>
                    <input type="text" id="lat" name="lat" class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-gray-400 focus:border-transparent" placeholder="e.g., 35.6895">
                </div>
                <div class="w-1/2">
                    <label for="lon" class="block text-sm font-medium text-gray-700 mb-1">Longitude</label>
                    <input type="text" id="lon" name="lon" class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-gray-400 focus:border-transparent" placeholder="e.g., 139.6917">
                </div>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea id="description" name="description" rows="4" class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-gray-400 focus:border-transparent" required placeholder="Provide a brief description of the location"></textarea>
            </div>

            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                <select id="category" name="category" class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-gray-400 focus:border-transparent">
                    <option value="NA">Select a category</option>
                    <option value="Healthcare">Healthcare</option>
                    <option value="Banks">Banks</option>
                    <option value="Public Services">Public Services</option>
                    <option value="Food">Food</option>
                    <option value="Retail">Retail</option>
                    <option value="Beauty">Beauty</option>
                    <option value="Fitness">Fitness</option>
                    <option value="Entertainment">Entertainment</option>
                    <option value="Education">Education</option>
                    <option value="Accommodation">Accommodation</option>
                    <option value="Pet Care">Pet Care</option>
                    <option value="Child Care">Child Care</option>
                </select>
            </div>

            <div>
                <label for="website" class="block text-sm font-medium text-gray-700 mb-1">Website</label>
                <input type="url" id="website" name="website" class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-gray-400 focus:border-transparent" value="http://example.com" placeholder="Enter the website URL">
            </div>

            <!-- Submit Button -->
            <button id="submit-topic" class="text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 w-full flex justify-center items-center">                
                <svg fill="#ffffff" height="32px" width="32px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M508.645,18.449c-2.929-2.704-7.133-3.51-10.826-2.085L6.715,204.446c-3.541,1.356-6.066,4.515-6.607,8.264 c-0.541,3.75,0.985,7.496,3.995,9.796l152.127,116.747c-0.004,0.116-0.575,0.224-0.575,0.342v83.592 c0,3.851,2.663,7.393,6.061,9.213c1.541,0.827,3.51,1.236,5.199,1.236c2.026,0,4.181-0.593,5.931-1.756l56.12-37.367 l130.369,99.669c1.848,1.413,4.099,2.149,6.365,2.149c1.087,0,2.186-0.169,3.248-0.516c3.27-1.066,5.811-3.672,6.786-6.974 L511.571,29.082C512.698,25.271,511.563,21.148,508.645,18.449z M170.506,321.508c-0.385,0.36-0.7,0.763-1.019,1.163 L31.659,217.272L456.525,54.557L170.506,321.508z M176.552,403.661v-48.454l33.852,25.887L176.552,403.661z M359.996,468.354 l-121.63-93.012c-1.263-1.77-2.975-3.029-4.883-3.733l-47.29-36.163L480.392,60.86L359.996,468.354z"></path> </g> </g> </g></svg>    
            </button>

            </form>
        </div>
    </div>

    <!-- Pop-Up Insert Review -->
    <div id="reviewFormDiv" class="modal hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center p-10">
        <div class="bg-white p-6 rounded-lg relative max-w-3xl w-full overflow-auto" style="max-height: calc(100vh - 200px);">

    <!-- Cancel Button -->
         <button id="close-modal-review-btn" class="absolute top-4 right-4 text-black">
            <svg width="24px" height="24px" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" stroke-width="3" stroke="#000" fill="none">
                <line x1="8.06" y1="8.06" x2="55.41" y2="55.94"></line>
                <line x1="55.94" y1="8.06" x2="8.59" y2="55.94"></line>
            </svg>
        </button>

        <!-- Form -->
        <h2 class="text-2xl font-bold text-gray-800 mb-4">New Review</h2>

        <form id="reviewForm" action="php/write_review_sql.php" method="post" class="space-y-4">
            
            <!-- Icon Selection Area -->
            <div class="grid grid-cols-4 gap-4 mb-4">
                <label class="cursor-pointer">
                    <input type="radio" name="user-icon" value="./img/1.png" class="hidden" checked>
                    <img src="./img/1.png" alt="1" class="w-20 h-20 object-cover border-2 border-transparent hover:border-blue-300 rounded-full">
                </label>
                <label class="cursor-pointer">
                    <input type="radio" name="user-icon" value="./img/2.png" class="hidden">
                    <img src="./img/2.png" alt="2" class="w-20 h-20 object-cover border-2 border-transparent hover:border-blue-300 rounded-full">
                </label>
                <label class="cursor-pointer">
                    <input type="radio" name="user-icon" value="./img/3.png" class="hidden">
                    <img src="./img/3.png" alt="3" class="w-20 h-20 object-cover border-2 border-transparent hover:border-blue-300 rounded-full">
                </label>
                <label class="cursor-pointer">
                    <input type="radio" name="user-icon" value="./img/4.png" class="hidden">
                    <img src="./img/4.png" alt="4" class="w-20 h-20 object-cover border-2 border-transparent hover:border-blue-300 rounded-full">
                </label>
                <label class="cursor-pointer">
                    <input type="radio" name="user-icon" value="./img/5.png" class="hidden">
                    <img src="./img/5.png" alt="4" class="w-20 h-20 object-cover border-2 border-transparent hover:border-blue-300 rounded-full">
                </label>
                <label class="cursor-pointer">
                    <input type="radio" name="user-icon" value="./img/6.png" class="hidden">
                    <img src="./img/6.png" alt="6" class="w-20 h-20 object-cover border-2 border-transparent hover:border-blue-300 rounded-full">
                </label>
                <label class="cursor-pointer">
                    <input type="radio" name="user-icon" value="./img/7.png" class="hidden">
                    <img src="./img/7.png" alt="7" class="w-20 h-20 object-cover border-2 border-transparent hover:border-blue-300 rounded-full">
                </label>
                <label class="cursor-pointer">
                    <input type="radio" name="user-icon" value="./img/8.png" class="hidden">
                    <img src="./img/8.png" alt="8" class="w-20 h-20 object-cover border-2 border-transparent hover:border-blue-300 rounded-full">
                </label>
            </div>

            <!-- Info -->
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 mb-1">User Name</label>
                <input type="text" id="username" name="username" class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-gray-400 focus:border-transparent" required placeholder="Enter the full address">
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="text" id="email" name="email" class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-gray-400 focus:border-transparent" required placeholder="Enter the full address">
            </div>

            <label for="Rating" class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
            <div class="star-rating">
                <input type="radio" id="star5" name="rating" value="5">
                <label for="star5" title="5 stars">★</label>
                <input type="radio" id="star4" name="rating" value="4">
                <label for="star4" title="4 stars">★</label>
                <input type="radio" id="star3" name="rating" value="3">
                <label for="star3" title="3 stars">★</label>
                <input type="radio" id="star2" name="rating" value="2">
                <label for="star2" title="2 stars">★</label>
                <input type="radio" id="star1" name="rating" value="1">
                <label for="star1" title="1 star">★</label>
            </div>
            <div>
                <label for="review" class="block text-sm font-medium text-gray-700 mb-1">Review</label>
                <textarea id="review" name="review" rows="5" class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-gray-400 focus:border-transparent" placeholder="Share your experience or review of this place"></textarea>
            </div>

            <!-- Hidden Place Value -->
            <input type="hidden" id="hiddenPlaceValue" name="hiddenPlaceValue" value="">

            <!-- Button -->
            <button id="send" class="text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 w-full flex justify-center items-center">
                <svg fill="#ffffff" height="32px" width="32px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M508.645,18.449c-2.929-2.704-7.133-3.51-10.826-2.085L6.715,204.446c-3.541,1.356-6.066,4.515-6.607,8.264 c-0.541,3.75,0.985,7.496,3.995,9.796l152.127,116.747c-0.004,0.116-0.575,0.224-0.575,0.342v83.592 c0,3.851,2.663,7.393,6.061,9.213c1.541,0.827,3.51,1.236,5.199,1.236c2.026,0,4.181-0.593,5.931-1.756l56.12-37.367 l130.369,99.669c1.848,1.413,4.099,2.149,6.365,2.149c1.087,0,2.186-0.169,3.248-0.516c3.27-1.066,5.811-3.672,6.786-6.974 L511.571,29.082C512.698,25.271,511.563,21.148,508.645,18.449z M170.506,321.508c-0.385,0.36-0.7,0.763-1.019,1.163 L31.659,217.272L456.525,54.557L170.506,321.508z M176.552,403.661v-48.454l33.852,25.887L176.552,403.661z M359.996,468.354 l-121.63-93.012c-1.263-1.77-2.975-3.029-4.883-3.733l-47.29-36.163L480.392,60.86L359.996,468.354z"></path> </g> </g> </g></svg>
            </button>
        </form>
        </div>
        </div>


    <!-- Main Chat Layout -->
    <div class="bg-gray-50 bg-opacity-50 w-[70%] shadow-lg rounded-lg flex h-[90vh]">

        <!-- Left Column (Topic List + Add Button) -->
        <div class="w-1/3 p-4 flex flex-col">
            <h2 class="text-lg font-semibold mb-4">Place</h2>
            <ul id="topic-list" class="flex-1 overflow-y-auto space-y-2">
                <!-- Topics will be dynamically added here -->
            </ul>

            <div class="flex flex-col space-y-4">
                <!-- Add Place -->
                <button id="show-modal-btn" class="text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">+ Place</button>
                <!-- Add Review -->
                <button id="show-modal-review-btn" class="text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">+ Review</button>
            </div>

            <!-- BG Credit -->
            <div class="text-left py-5">
                <a href="http://www.freepik.com" class="text-gray-400 no-underline">Background by pikisuperstar / Freepik</a>
            </div>
        </div>

        <!-- Right Column (Chat Window + Input) -->
        <div class="w-2/3 flex flex-col h-full">
            
            <!-- Selected Topic -->
            <div class="text-blue-500 p-4 flex justify-between items-center rounded-t-lg">
                <h2 id="currTopic" class="text-lg font-semibold">Welcome to the Network for Expats in Japan!</h2>
                <h2 id="curr_place_id" class="text-lg font-semibold"></h2>
            </div>
            
            <!-- Content Container (Topic Area + Review Area) -->
            <div class="flex-1 flex flex-col overflow-y-auto">
                
                <!-- Topic Area -->
                <div id="discussion" class="p-4 overflow-y-auto space-y-4 min-h-[300px]">
                        Click on any facility from the list on the left and add your review!
                </div>

                <!-- Review Area -->
                <div id="reviewArea" class="p-4 overflow-y-auto space-y-4">
                    No reviews yet. Be the first to add one here!
                </div>
                
            </div>
        </div>
    </div>

    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Custom JS -->
    <script type="module" src="./js/_main.js?v=<?php echo time(); ?>"></script>
    <script src="./js/_upload.js?v=<?php echo time(); ?>"></script>

</body>
</html>


