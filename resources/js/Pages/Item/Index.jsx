import { ItemList } from '@/Components/Item/ItemList';
import { InnerLayout } from '@/Layouts/InnerLayout';
import MainLayout from '@/Layouts/MainLayout';
import axios from 'axios';
import { useState, useEffect } from 'react';

const Index = ({ auth, categories, items }) => {
  const [renderItems, setRenderItems] = useState([]);
  const [selectedCategory, setSelectedCategory] = useState('');

  useEffect(() => {
    console.log(items);
    setRenderItems(items);
  }, []);

  useEffect(() => {
    fetchItems();
  }, [selectedCategory]);

  const handleChangeCategory = async (e) => {
    setSelectedCategory(e.target.value);
  };

  const getParams = () => {
    const params = {};
    params.category_id = selectedCategory;
    return params;
  };

  const fetchItems = async () => {
    try {
      const params = getParams();
      const response = await axios.get('/api/item', {
        params,
      });
      console.log(response.data);
      setRenderItems(response.data);
    } catch (e) {
      console.error(e);
    }
  };

  return (
    <MainLayout user={auth.user}>
      <InnerLayout title="商品マスタ一覧">
        <div className="w-full text-center mt-5">
          <label htmlFor="categoryList" className="inline-block text-xs mr-1">
            カテゴリー：
          </label>
          <select
            className="h-8 text-xs border-0 border-b border-cyan-300"
            id="categoryList"
            onChange={handleChangeCategory}
          >
            <option value="">全て</option>
            {categories?.map((item) => (
              <option key={item.id} value={item.id}>
                {item.name}
              </option>
            ))}
          </select>
        </div>
        <ItemList items={renderItems} />
      </InnerLayout>
    </MainLayout>
  );
};

export default Index;
