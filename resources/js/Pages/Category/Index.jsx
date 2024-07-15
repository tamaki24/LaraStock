import { ItemList } from '@/Components/Category/ItemList';
import { InnerLayout } from '@/Layouts/InnerLayout';
import MainLayout from '@/Layouts/MainLayout';

const Index = ({ auth, categories }) => {
  return (
    <MainLayout user={auth.user}>
      <InnerLayout title="カテゴリー一覧">
        <ItemList categories={categories} />
      </InnerLayout>
    </MainLayout>
  );
};

export default Index;
