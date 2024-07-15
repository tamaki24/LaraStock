import { InnerLayout } from '@/Layouts/InnerLayout';
import MainLayout from '@/Layouts/MainLayout';
import { useState, useEffect } from 'react';

const Create = ({ auth }) => {
  const [editCategory, setEditCategory] = useState({
    name: '',
    storage: '',
  });
  const [errorMessage, setErrorMessage] = useState('');
  const [successMessage, setSuccessMessage] = useState('');
  const [validationMessage, setValidationMessage] = useState('');

  useEffect(() => {}, []);

  const handleSubmit = (e) => {
    e.preventDefault();
    // データの更新処理
    setErrorMessage('');
    console.log(editCategory);
    const bool = validation();
    if (bool) {
      axios
        .post(`/api/category`, editCategory)
        .then((response) => {
          console.log('Category created:', response.data);
          setSuccessMessage('登録が完了しました。 リダイレクトしています...');
          // リダイレクト
          setTimeout(() => {
            setSuccessMessage('');
            window.location.href = '/category';
          }, 2000);
        })
        .catch((e) => {
          console.error('Error creating category:', e);
          setErrorMessage('登録に失敗しました。');
        });
    }
  };

  const validation = () => {
    setValidationMessage('');
    let message = '';

    if (editCategory.name === '') {
      message += 'カテゴリー名が入力されていません。　';
    }

    if (editCategory.storage === '') {
      message += '保管場所が入力されていません。　';
    }

    if (message === '') {
      return true;
    }

    setValidationMessage(message);
    return false;
  };

  const handleDelete = () => {
    // 削除処理
    const confirmed = window.confirm('本当に削除しますか？');
    if (!confirmed) {
      return;
    }
  };

  const handleChange = (e) => {
    const { name, value } = e.target;
    setEditCategory({
      ...editCategory,
      [name]: value,
    });
  };

  return (
    <MainLayout user={auth.user}>
      <InnerLayout title="カテゴリー登録">
        <div className="max-w-md mx-auto mt-10">
          <form onSubmit={handleSubmit} className="bg-white  px-8 pt-6 pb-8 mb-4">
            <div className="mb-4">
              <label htmlFor="name" className="block text-gray-700 text-sm font-bold mb-2">
                カテゴリー名
              </label>
              <input
                type="text"
                name="name"
                value={editCategory.name}
                onChange={handleChange}
                className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              />
            </div>
            <div className="mb-4">
              <label htmlFor="storage" className="block text-gray-700 text-sm font-bold mb-2">
                保管場所
              </label>
              <input
                type="text"
                name="storage"
                value={editCategory.storage}
                onChange={handleChange}
                className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              />
            </div>

            <div className="flex items-center justify-between">
              <button
                className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                type="submit"
              >
                Save
              </button>
              <button
                className="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                type="button"
                onClick={handleDelete}
              >
                delete
              </button>
            </div>
            {validationMessage !== '' && (
              <p className="my-2 text-xs text-red-400 break-words">{validationMessage}</p>
            )}

            {errorMessage !== '' && (
              <p className="my-2 text-xs text-red-400 break-words">{errorMessage}</p>
            )}

            {successMessage !== '' && (
              <p className="my-2 text-xs font-bold text-cyan-500 break-words">{successMessage}</p>
            )}
          </form>
        </div>
      </InnerLayout>
    </MainLayout>
  );
};

export default Create;
