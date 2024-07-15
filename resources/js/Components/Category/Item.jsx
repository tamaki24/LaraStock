import { Link } from '@inertiajs/react';

export const Item = ({ props }) => {
  const { id, name, storage } = props;

  return (
    <div className={`py-2 border-l-8 bg-gray-100 pl-3 mb-3 w-full mr-3`}>
      <div className="flex items-start pb-1 w-max">
        <p className="text-xl font-bold pr-3">{name}</p>
      </div>
      <div className="w-max flex justify-between min-w-[800px]">
        <div className="text-start min-w-[360px] max-w-[400px]">
          <p className="pr-3">保管場所： {storage}</p>
        </div>

        <Link href={`/category/${id}`}>
          <button className="bg-cyan-500 hover:bg-cyan-700 text-white font-bold px-4 rounded mr-5 focus:outline-none focus:shadow-outline text-sm h-8">
            編集
          </button>
        </Link>
      </div>
    </div>
  );
};
