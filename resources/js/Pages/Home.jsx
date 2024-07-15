import { ItemList } from '@/Components/Stock/ItemList';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { InnerLayout } from '@/Layouts/InnerLayout';
import MainLayout from '@/Layouts/MainLayout';
import { Head } from '@inertiajs/react';

const Home = ({ auth, stocks }) => {
  return (
    <MainLayout user={auth.user}>
      <InnerLayout title={'Home'}>
        <ItemList title={'期限が近い在庫'} stocks={stocks} />
      </InnerLayout>
    </MainLayout>
  );
};

export default Home;
