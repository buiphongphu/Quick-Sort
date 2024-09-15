<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sắp xếp Nâng Cao (Quick Sort)</title>
    <style>
        /* Tổng quan */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            text-align: center;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
        }

        /* Tiêu đề */
        h1 {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }

        /* Hiển thị mảng */
        .array-container {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .array-item {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: #007bff;
            color: white;
            margin: 0 5px;
            padding: 10px;
            border-radius: 4px;
            font-size: 18px;
            width: 50px;
            height: 80px;
            text-align: center;
            transition: transform 0.5s ease, background-color 0.5s ease;
        }

        .sorted {
            background-color: #dc3545;
        }

        .index-label {
            font-size: 12px;
            color: #fff;
            margin-bottom: 5px;
        }

        /* Hiệu ứng button */
        #start-button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            border: none;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        #start-button:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }

        #start-button:active {
            background-color: #004085;
            transform: translateY(0);
        }

        /* Bước sắp xếp */
        #steps {
            margin-top: 20px;
            text-align: left;
            max-width: 400px;
            margin: 0 auto;
        }

        .step-item {
            padding: 5px;
            border-bottom: 1px solid #ddd;
            background-color: #f9f9f9;
            border-radius: 4px;
            margin-bottom: 5px;
            transition: background-color 0.3s ease;
        }

        .step-item:hover {
            background-color: #ececec;
        }

        .highlight {
            background-color: #ffc107;
        }

        .array-label {
            font-size: 18px;
            font-weight: bold;
        }

        #array-input {
            padding: 5px;
            font-size: 16px;
            width: 100%;
            margin-top: 10px;
        }

        /* Ẩn form khi cần thiết */
        .hidden {
            display: none;
        }

        .submit {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            border: none;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .submit:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }

        .submit:active {
            background-color: #004085;
            transform: translateY(0);
        }
        .array-start {
            margin-bottom: 20px;
            font-size: 18px;
            font-weight: bold;
            color: #333;
            text-align: center;
        }
    </style>
</head>

<body>
<div class="container">
    <h1>Sắp xếp Nhanh (Quick Sort)</h1>

    <!-- Form nhập mảng -->
    <form id="array-form" method="POST">
        <label class="array-label" for="array-input">Nhập mảng (các số cách nhau bởi dấu phẩy):</label><br>
        <input type="text" id="array-input" name="array-input" required>
        <br><br>
        <input class="submit" type="submit" value="Lưu">
    </form>

    <?php
    $array = [];
    $steps = [];

    // Kiểm tra nếu người dùng đã gửi form
    if (isset($_POST['array-input'])) {
        // Lấy dữ liệu mảng từ người dùng và chuyển đổi thành array
        $input = $_POST['array-input'];
        $array = array_map('intval', explode(',', $input));

        // Hàm Quick Sort và Partition
        function quickSort(&$array, $low, $high, &$steps) {
            if ($low < $high) {
                $pi = partition($array, $low, $high, $steps);
                quickSort($array, $low, $pi - 1, $steps);
                quickSort($array, $pi + 1, $high, $steps);
            }
        }

        function partition(&$array, $low, $high, &$steps) {
            $pivot = $array[$high];
            $i = $low - 1;

            for ($j = $low; $j < $high; $j++) {
                if ($array[$j] < $pivot) {
                    $i++;
                    $temp = $array[$i];
                    $array[$i] = $array[$j];
                    $array[$j] = $temp;
                    $steps[] = ['array' => array_slice($array, 0), 'swap' => [$i, $j]];
                }
            }

            $temp = $array[$i + 1];
            $array[$i + 1] = $array[$high];
            $array[$high] = $temp;
            $steps[] = ['array' => array_slice($array, 0), 'swap' => [$i + 1, $high]];

            return $i + 1;
        }

        // Gọi hàm sắp xếp
        quickSort($array, 0, count($array) - 1, $steps);
    }
    ?>

    <!-- Hiển thị minh họa -->
    <div id="arr"></div>
    <div id="array-container" class="array-container"></div>
    <button id="start-button">Bắt đầu</button>
    <div id="steps"></div>
</div>

<script>
    const steps = <?php echo json_encode($steps); ?>;
    const arrayContainer = document.getElementById('array-container');
    const startButton = document.getElementById('start-button');
    const arrstart = document.getElementById('arr');
    const stepsContainer = document.getElementById('steps');
    const form = document.getElementById('array-form');
    let items = [];


    function initializeArray() {
        arrayContainer.innerHTML = '';
        arrstart.innerHTML = '';
        stepsContainer.innerHTML = '';

        // Hiển thị mảng ban đầu trước khi sắp xếp
        <?php $arr=$_POST['array-input']; ?>
        const arr = <?php echo json_encode($arr); ?>;
        const arrDiv = document.createElement('div');
        arrDiv.className = 'array-start';
        arrDiv.textContent = 'Mảng ban đầu: ' + arr;
        arrstart.appendChild(arrDiv);

        if (steps.length > 0) {
            steps[0].array.forEach((value, index) => {
                const item = document.createElement('div');
                item.className = 'array-item';

                const indexLabel = document.createElement('div');
                indexLabel.className = 'index-label';
                indexLabel.textContent = `Vị trí ${index}`;
                item.appendChild(indexLabel);

                const valueDiv = document.createElement('div');
                valueDiv.textContent = `${value}`;
                item.appendChild(valueDiv);

                arrayContainer.appendChild(item);
                items.push(item);
            });
        }
    }



    function displayStep(stepIndex) {
        if (stepIndex >= steps.length) {
            startButton.textContent = "Hoàn tất";
            form.classList.remove('hidden');  // Hiện form trở lại khi hoàn tất
            return;
        }

        const currentArray = steps[stepIndex].array;
        const [swapIndex1, swapIndex2] = steps[stepIndex].swap;

        const stepDiv = document.createElement('div');
        stepDiv.className = 'step-item';
        stepDiv.textContent = 'Bước ' + (stepIndex + 1) + ': Hoán đổi vị trí ' + swapIndex1 + ' và ' + swapIndex2 + ' -> ' + currentArray.join(', ');
        stepsContainer.appendChild(stepDiv);

        items[swapIndex1].classList.add('highlight');
        items[swapIndex2].classList.add('highlight');

        setTimeout(() => {
            currentArray.forEach((value, index) => {
                items[index].children[1].textContent = `${value}`;
                items[index].classList.remove('highlight');
                if (stepIndex === steps.length - 1) {
                    items[index].classList.add('sorted');
                }
            });

            setTimeout(() => displayStep(stepIndex + 1), 1000);
        }, 1000);
    }

    startButton.addEventListener('click', () => {
        initializeArray();
        displayStep(0);
    });
</script>
</body>

</html>
