import { Head } from '@inertiajs/react';
import React from 'react';

export const InnerLayout = ({ title, children }) => {
  return (
    <>
      <Head title={title} />
      <div className="py-12 w-full">
        <div className="min-w-[900px] mx-auto px-6 ">
          <div className="bg-white overflow-hidden shadow-sm rounded-lg">
            <h2 className="text-2xl font-bold mt-5 text-center">{title}</h2>
            <div className="px-6">{children}</div>
          </div>
        </div>
      </div>
    </>
  );
};
